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
                <div class="btn-group" role="group" aria-label="Basic example">
                    <button type="button" class="btn btn-dark" @click.stop="sendRequest('books')">Show Books</button>
                    <button type="button" class="btn btn-dark" @click.stop="sendRequest('books/1')">Show Book #1</button>
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
        }
    },
    methods: {
        async sendRequest(path = 'books') {
            this.apiError = null;
            const response = await fetch(`/api/${path}`);

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
