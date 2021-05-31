@extends('layout')

@section('title', config('app.name'))

@section('content')
<div class="container">
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
            <div id="app">
                <div class="btn-toolbar" role="toolbar">
                    <div class="btn-group me-2" role="group" aria-label="Basic example">
                        <button type="button" class="btn btn-dark" @click.stop="sendRequest('books')">Show Books</button>
                    </div>
                    <div class="input-group me-2">
                        <button type="button" class="btn btn-dark" @click.stop="sendRequest(`books/${showBookId}`)">Show Book #</button>
                        <input v-model="showBookId" type="number" class="form-control" style="width:80px">
                    </div>
                    <div class="btn-group me-2" role="group" aria-label="Basic example">
                        <button type="button" class="btn btn-dark" data-bs-toggle="modal" data-bs-target="#createBookModal">Create Book</button>
                        <div class="modal fade" id="createBookModal" tabindex="-1" aria-labelledby="exampleModalLabel" aria-hidden="true">
                            <div class="modal-dialog">
                                <div class="modal-content">
                                    <div class="modal-header">
                                        <h5 class="modal-title" id="exampleModalLabel">Book</h5>
                                        <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                                    </div>
                                    <div class="modal-body">
                                        <div class="mb-2">
                                            <input v-model="book.title" type="text" class="form-control" placeholder="Title">
                                        </div>
                                        <div class="mb-2">
                                            <input v-model="book.pages_count" type="number" class="form-control" placeholder="Pages count">
                                        </div>
                                        <div class="mb-2">
                                            <input v-model="book.year" type="number" class="form-control" placeholder="Year">
                                        </div>
                                        <div class="mb-2">
                                            <textarea v-model="book.description" class="form-control" placeholder="Description"></textarea>
                                        </div>
                                        <div class="mb-2">
                                            <select v-model="book.authors" class="form-select" aria-label="Authors" placeholder="Authors">
                                                <option value="1">One</option>
                                                <option value="2">Two</option>
                                                <option value="3">Three</option>
                                            </select>
                                        </div>
                                    </div>
                                    <div class="modal-footer">
                                        <button type="button" class="btn btn-primary">Save</button>
                                    </div>
                                </div>
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
    </div>
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

            book: {
                title: null,
                pages_count: 0,
                year: null,
                description: null,
                authors: [],
            },
        }
    },
    methods: {
        async sendRequest(path, method = 'GET', head = {}, params = null) {
            this.apiError = null;
            const headers = new Headers(head);
            const requestParams = { method, headers }
            if (params) requestParams.body = JSON.stringify(params);

            const response = await fetch(`/api/${path}`, requestParams);

            if (response.status === 200) {
                const data = await response.json();
                this.print(JSON.stringify(data, null, 4));
            } else {
                this.apiError = `${response.status} ${response.statusText}`;
                this.print();
            }
        },

        print(text = null) {
            this.apiResult = text;
        },
    },
}
Vue.createApp(App).mount('#app');
</script>
@endpush
