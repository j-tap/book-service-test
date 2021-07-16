@extends('layout')

@section('title', config('app.name'))

@section('content')
<div id="app" class="container">
    <div class="row my-3">
        <div class="col-12">
            <div class="card">
                <div class="card-body">
                    <p>Сервис для работы с книгами<br>
                    Книга имеет одного или несколько авторов.<br>
                    А так же к книге можно прикреплять комментарии.</p>
                    <p>Реализовать API для:</p>
                    <ol>
                        <li>создания авторов и книг
                        <li>получения списка книг по автору/авторам
                        <li>получение информации о конкретном авторе со списком его книг
                        <li>получение информации о конкретной книге с ее авторами и комментариями
                        <li>для комментариев сделать поддержку пагинации
                        <li>удаление книги / автора
                    </ol>
                </div>
            </div>
        </div>
    </div>

    <div class="row my-3">
        <div class="col-12">
            <div class="btn-toolbar" role="toolbar">
                <div class="btn-group me-2" role="group">
                    <button type="button" class="btn btn-dark" @click.stop="sendRequest('books')">Show Books</button>
                </div>
                <div class="input-group me-2">
                    <button type="button" class="btn btn-dark" @click.stop="sendRequest(`books/${showBookId}`)">Show Book #</button>
                    <input v-model="showBookId" type="number" class="form-control" style="width:80px">
                </div>
                <div class="btn-group me-2" role="group">
                    <button type="button" class="btn btn-dark" data-bs-toggle="modal" data-bs-target="#createBookModal">Create Book</button>
                </div>
            </div>
            <div class="alert alert-danger mt-2" role="alert" v-show="apiError" v-html="apiError"></div>
            <div class="card mt-3">
                <div class="card-header">
                    <span>Result</span>
                    <button type="button" class="btn btn-outline-dark btn-sm float-end" @click.stop="print()">&times;</button>
                </div>
                <div class="card-body">
                    <pre><code v-html="apiResult" style="white-space:pre"></code></pre>
                </div>
            </div>
        </div>
    </div>

    <x-modal name="createBookModal" title="Book" success-event="sendRequest('books', 'POST', book)">
        <x-forms.input name="title" validation="errorsValidation.title" class="mb-2"/>
        <x-forms.input name="year" validation="errorsValidation.year" type="number" class="mb-2"/>
        <x-forms.input name="pages_count" validation="errorsValidation.pages_count" class="mb-2"/>
        <x-forms.textarea name="description" validation="errorsValidation.description" class="mb-2"/>
        <x-forms.select name="authors" validation="errorsValidation.authors" items="authors.items" multiple class="mb-2"/>
    </x-modal>
</div>
@endsection

@push('scripts')
<script>
const App = {
    data() {
        return {
            apiError: null,
            apiResult: null,

            showBookId: 1,
            errorsValidation: {},

            book: {
                title: null,
                pages_count: 0,
                year: null,
                description: null,
                authors: [],
            },

            authors: {
                list: [],
                items: [],
            },
        }
    },

    watch: {
        'authors.list': function(val) {
            const authors = val
                .map(o => ({ value: o.id, text: `${o.first_name} ${o.last_name}` }));
            this.authors.items = authors;
        },

    },

    mounted() {
        this.fetchAuthors()
        this.$refs.createBookModal.addEventListener('hidden.bs.modal', () => {
            this.clearFormModal();
        });
    },

    methods: {
        printError(text = '') {
            this.apiError = text
        },

        print(text = null) {
            this.apiResult = text;
        },

        clearFormModal() {
            const fields = this.$refs.createBookModal.querySelectorAll('[name]');
            for (let field of fields) {
                field.value = null;
            }
        },

        async fetchAuthors() {
            const authors = await this.send('authors');
            this.authors.list = authors.data;
        },

        async sendRequest(path, method, params, head) {
            this.errorsValidation = {};
            const result = await this.send(path, method, params, head)
            this.clearFormModal();
            this.printError(result.error || '');
            this.print(JSON.stringify(result.data, null, 4));
        },

        async send(path, method, params, head) {
            this.apiError = null;
            let data = null;
            let error = null;
            let resp = null;
            const successCodes = [200, 201];

            try {
                const response = await this.fetchApi(path, method, params, head);
                const resp = await response.json();

                if (resp.data) {
                    data = resp.data;
                } else {
                    if (resp.message) {
                        error = resp.message
                        if (resp.errors) this.errorsValidation = resp.errors
                    } else {
                        error = `${resp.status} ${resp.statusText}`;
                    }
                }
                // if (successCodes.includes(resp.status)) {
                //     data = resp.data;
                // } else {
                //     if (resp.message) {
                //         error = resp.message
                //         if (resp.errors) this.errorsValidation = resp.errors
                //     } else {
                //         error = `${resp.status} ${resp.statusText}`;
                //     }
                // }
            } catch (err) {
                if (err.response && err.response.data && err.response.data.message) {
                    error = err.response.data.message
                } else {
                    error = `${err.name}: ${err.message}`
                }
            }
            return { data, error }
        },

        async fetchApi(path, method = 'GET', params = null, head = {}) {
            const headers = new Headers({
                ...{
                    'Accept': 'application/json',
                    'Content-Type': 'application/json;charset=UTF-8',
                    'Content-Length': 2447,
                },
                ...head,
            });
            const requestParams = {
                method,
                headers,
            }
            if (params) requestParams.body = JSON.stringify(params);

            const result = await fetch(`/api/${path}`, requestParams);
            return result
        },

    },
}
Vue.createApp(App).mount('#app');
</script>
@endpush
