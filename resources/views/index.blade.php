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
                        <li>&check; создания авторов и книг
                        <li>&check; получения списка книг по автору/авторам
                        <li>&check; получение информации о конкретном авторе со списком его книг
                        <li>получение информации о конкретной книге с ее авторами и комментариями
                        <li>для комментариев сделать поддержку пагинации
                        <li>&check; удаление книги / автора
                    </ol>
                </div>
            </div>
        </div>
    </div>

    <div class="row my-3">
        <div class="col-12">
            <ul class="nav nav-tabs mb-3" id="modelManageTabs" role="tablist">
                <li class="nav-item" role="presentation">
                    <button class="nav-link active" id="booksTab-tab" data-bs-toggle="tab" data-bs-target="#booksTab" type="button" role="tab" aria-controls="booksTab" aria-selected="true">Books</button>
                </li>
                <li class="nav-item" role="presentation">
                    <button class="nav-link" id="authorTab-tab" data-bs-toggle="tab" data-bs-target="#authorTab" type="button" role="tab" aria-controls="authorTab" aria-selected="false">Authors</button>
                </li>
            </ul>
            <div class="tab-content" id="modelManageTabsContent">
                <div class="tab-pane fade show active" id="booksTab" role="tabpanel" aria-labelledby="booksTab-tab">
                    <div class="btn-toolbar" role="toolbar">
                        <div class="btn-group me-2 mb-2" role="group">
                            <button type="button" class="btn btn-dark" @click.stop="createEntity('book')">Create Book</button>
                        </div>
                        <div class="btn-group me-2 mb-2" role="group">
                            <button type="button" class="btn btn-dark" @click.stop="editEntity('book')">Edit Book</button>
                            <input v-model="book.editId" type="number" class="form-control" style="width:80px">
                        </div>
                        <div class="btn-group me-2 mb-2" role="group">
                            <button type="button" class="btn btn-dark" @click.stop="sendRequest(pathes.book)">Show all Books</button>
                        </div>
                        <div class="input-group me-2 mb-2" role="group">
                            <button type="button" class="btn btn-dark" @click.stop="sendRequest(`${pathes.book}/${book.showId}`)">Show Book #</button>
                            <input v-model="book.showId" type="number" class="form-control" style="width:80px">
                        </div>
                        <div class="input-group me-2 mb-2">
                            <button type="button" class="btn btn-dark" @click.stop="deleteEntity('book')">Delete Book #</button>
                            <input v-model="book.deleteId" type="number" class="form-control" style="width:80px">
                        </div>
                    </div>
                    <div>
                        <div class="input-group me-2 mb-2">
                            <button type="button" class="btn btn-dark" @click.stop="sendRequest(pathes.book, 'GET', {title: book.filters.title})">Search by title</button>
                            <input v-model="book.filters.title" class="form-control" style="width:200px">
                        </div>
                        <div class="input-group me-2 mb-2">
                            <button type="button" class="btn btn-dark" @click.stop="sendRequest(pathes.book, 'GET', {authors: book.filters.authors})">Books by Authors</button>
                            <select v-model="book.filters.authors" class="form-control"  style="width:300px" multiple>
                                <option value="null" selected>None</option>
                                <option v-for="author in author.list" :value="author.id" v-text="`${author.first_name} ${author.last_name}`"></option>
                            </select>
                        </div>
                    </div>
                </div>
                <div class="tab-pane fade" id="authorTab" role="tabpanel" aria-labelledby="authorTab-tab">
                    <div class="btn-toolbar" role="toolbar">
                        <div class="btn-group me-2 mb-2" role="group">
                            <button type="button" class="btn btn-dark" @click.stop="createEntity('author')">Create Author</button>
                        </div>
                        <div class="btn-group me-2 mb-2" role="group">
                            <button type="button" class="btn btn-dark" @click.stop="editEntity('author')">Edit Author</button>
                            <input v-model="author.editId" type="number" class="form-control" style="width:80px">
                        </div>
                        <div class="btn-group me-2 mb-2" role="group">
                            <button type="button" class="btn btn-dark" @click.stop="sendRequest(pathes.author)">Show all Authors</button>
                        </div>
                        <div class="input-group me-2 mb-2">
                            <button type="button" class="btn btn-dark" @click.stop="sendRequest(`${pathes.author}/${author.showId}`)">Show Author #</button>
                            <input v-model="author.showId" type="number" class="form-control" style="width:80px">
                        </div>
                        <div class="input-group me-2 mb-2">
                            <button type="button" class="btn btn-dark" @click.stop="deleteEntity('author')">Delete Author #</button>
                            <input v-model="author.deleteId" type="number" class="form-control" style="width:80px">
                        </div>
                    </div>
                    <div>
                        <div class="input-group me-2 mb-2">
                            <button type="button" class="btn btn-dark" @click.stop="sendRequest(pathes.author, 'GET', {name: author.filters.name})">Search by name</button>
                            <input v-model="author.filters.name" class="form-control" style="width:200px">
                        </div>
                    </div>
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

    <x-modal name="createBookModal" title="Book" success-event="saveBtn('book')">
        <x-forms.input name="title" value="book.model.title" validation="errorsValidation.title" class="mb-2"/>
        <x-forms.input name="year" value="book.model.year" validation="errorsValidation.year" type="number" class="mb-2"/>
        <x-forms.input name="pages_count" value="book.model.pages_count" validation="errorsValidation.pages_count" class="mb-2"/>
        <x-forms.textarea name="description" value="book.model.description" validation="errorsValidation.description" class="mb-2"/>
        <x-forms.select name="authors" value="book.model.authors" validation="errorsValidation.authors" items="author.items" multiple class="mb-2"/>
    </x-modal>

    <x-modal name="createAuthorModal" title="Author" success-event="saveBtn('author')">
        <x-forms.input name="first_name" value="author.model.first_name" validation="errorsValidation.first_name" class="mb-2"/>
        <x-forms.input name="last_name" value="author.model.last_name" validation="errorsValidation.last_name" class="mb-2"/>
        <x-forms.date name="birthday" value="author.model.birthday" validation="errorsValidation.birthday" class="mb-2"/>
        <x-forms.textarea name="description" value="author.model.description" validation="errorsValidation.description" class="mb-2"/>
    </x-modal>
</div>
@endsection

@push('scripts')
<script>
const App = {
    data() {
        return {
            loading: false,
            apiError: null,
            apiResult: null,

            errorsValidation: {},

            pathes: {
                book: 'books',
                author: 'authors',
            },

            isEditModal: false,

            book: {
                showId: 0,
                editId: 0,
                deleteId: 0,
                filters: {
                    title: null,
                    authors: [],
                },
                model: {
                    title: null,
                    pages_count: 0,
                    year: null,
                    description: null,
                    authors: [],
                },
                list: [],
                items: [],
            },
            author: {
                showId: 0,
                editId: 0,
                deleteId: 0,
                filters: {
                    name: null,
                },
                model: {
                    first_name: null,
                    last_name: null,
                    description: null,
                    birthday: null,
                },
                list: [],
                items: [],
            },

        }
    },

    watch: {
        'author.list': function(val) {
            const result = val
                .map(o => ({ value: o.id, text: `${o.first_name} ${o.last_name}` }));
            this.author.items = result;
        },

        'book.list': function(val) {
            const result = val
                .map(o => ({ value: o.id, text: o.title }));
            this.book.items = result;
        },

        loading(is) {
            document.body.style.cursor = is ? 'wait' : 'default';
        },

    },

    mounted() {
        this.fetchEntity('author');

        this.$refs.createBookModal
            .addEventListener('show.bs.modal', () => {
                this.fetchEntity('book');
                this.fetchEntity('author');
            });
        this.$refs.createBookModal
            .addEventListener('hidden.bs.modal', () => {
                this.clearFormModal('book');
            });

        this.$refs.createAuthorModal
            .addEventListener('show.bs.modal', () => {
                this.fetchEntity('author');
            });
        this.$refs.createAuthorModal
            .addEventListener('hidden.bs.modal', () => {
                this.clearFormModal('author');
            });
    },

    methods: {
        printError(text = '') {
            this.apiError = text
        },

        print(text = null) {
            this.apiResult = text;
        },

        clearFormModal(type) {
            Object.assign(this.$data[type].model, this.$options.data.call(this)[type].model)
        },

        async fetchEntity(type) {
            const resp = await this.send(this.pathes[type]);
            this[type].list = resp.data;
        },

        createEntity(type) {
            const name = type.charAt(0).toUpperCase() + type.slice(1);
            const modal = new bootstrap.Modal(this.$refs[`create${name}Modal`], { keyboard: false })
            modal.show();
            this.isEditModal = false;
        },

        async editEntity(type) {
            const result = await this.send(`${this.pathes[type]}/${this[type].editId}`);
            this.printError(result.error || '');
            if (!result.error) {
                const model = this[type].model;
                const newData = { ...model };

                Object.keys(model).forEach(k => {
                    let val = result.data[k];
                    if (Array.isArray(val)) val = val.map(o => o.id);
                    if (result.data[k]) newData[k] = val;
                })

                this[type].model = newData;
                const name = type.charAt(0).toUpperCase() + type.slice(1);
                const modal = new bootstrap.Modal(this.$refs[`create${name}Modal`], { keyboard: false })
                modal.show();
                this.isEditModal = true;
            }
        },

        async deleteEntity(type) {
            const result = await this.send(`${this.pathes[type]}/${this[type].deleteId}`, 'DELETE');
            this.printError(result.error || '');
            this.print(JSON.stringify(result.data, null, 4));
        },

        async sendRequest(path, method, params, head) {
            this.errorsValidation = {};
            const result = await this.send(path, method, params, head)
            this.printError(result.error || '');
            this.print(JSON.stringify(result.data, null, 4));
        },

        saveBtn(type) {
            const typeData = this[type]
            const method = this.isEditModal ? 'PUT' : 'POST';
            let url = this.pathes[type]
            if (this.isEditModal) url += `/${typeData.editId}`
            this.sendRequest(url, method, typeData.model)
        },

        async send(path, method, params, head) {
            this.loading = true
            this.apiError = null;
            let data = null;
            let error = null;
            let resp = null;

            try {
                const response = await this.fetchApi(path, method, params, head);
                const resp = await response.json();
                // console.log(response, resp);
                if (resp.data) {
                    data = resp.data;
                } else if (response.ok) {
                    data = response.statusText;
                } else {
                    if (resp.message) {
                        error = resp.message
                        if (resp.errors) this.errorsValidation = resp.errors
                    } else {
                        error = `${resp.status} ${resp.statusText}`;
                    }
                }
            } catch (err) {
                if (err.response && err.response.data && err.response.data.message) {
                    error = err.response.data.message
                } else {
                    error = `${err.name}: ${err.message}`
                }
            }
            this.loading = false
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
            if (params) {
                if (method !== 'GET') {
                    requestParams.body = JSON.stringify(params);
                } else {
                    const strParams = Object.keys(params).map(key => key + '=' + params[key]).join('&');
                    path += `?${strParams}`;
                }
            }

            const result = await fetch(`/api/${path}`, requestParams);
            return result
        },

    },
}
Vue.createApp(App).mount('#app');
</script>
@endpush
