@extends('layouts.app')
@push('styles')
@endpush
@section('content')
    <div class="container-fluid">
        <div class="row justify-content-center">
            <div class="col-md-12">
                <div class="card">
                    <div class="card-header">Chat</div>
                    <div class="card-body">
                        <div class="row p-2">
                            <div class="col-10">
                                <div class="row">
                                    <div class="col-12">
                                        <ul id="messages" class="list-unstyled overflow-auto" style="height: 50vh">
                                            <li>Test 1: Hello</li>
                                            <li>Test 2: HHie </li>
                                        </ul>
                                    </div>
                                </div>
                                <div class="row">
                                    <div class="col-10 py-3">
                                        <input type="text" id="message" class="form-control">
                                    </div>
                                    <div class="col-2  py-3">
                                        <button id="send" type="submit" class="btn btn-primary btn-block">Send</button>
                                    </div>
                                </div>
                            </div>
                            <div class="col-2">
                                <p><strong> Online Now</strong></p>
                                <ul id="users" class="list-unstyled overflow-auto text-info" style="height: 45vh">
                                </ul>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
@endsection
@push('scripts')
    <script>
        //presence channel
        //handle list of user connected your current chat
        //must know the current user joined on that channel on the same socket
        //join : recieves the name of the presence channel we are using 
        const usersElement = document.getElementById('users');
        const messagesElement = document.getElementById('messages');
        Echo.join('chat')
            .here((users) => {
                console.log(users)
                users.forEach((user) => {
                    let element = document.createElement('li');
                    element.setAttribute('id', user.id)
                    element.innerText = user.name
                    usersElement.appendChild(element)
                })
            })
            .joining((user) => {
                let element = document.createElement('li');
                element.setAttribute('id', user.id)
                element.innerText = user.name
                usersElement.appendChild(element)
            })
            .leaving((user) => {
                const element = document.getElementById(user.id)
                element.parentNode.removeChild(element)
            })
            .listen('MessageSent', (e)=>{
                let element = document.createElement('li');
                element.innerText = e.message
                messagesElement.appendChild(element)
            })
    </script>
    <script>
        const messageElement = document.getElementById('message');
        const sendElement = document.getElementById('send');
        sendElement.addEventListener('click', (e)=>{
            e.preventDefault();
            window.axios.post('/chat/message',{
                message: messageElement.value,
            });
            messageElement.value = '';
        })
    </script>
@endpush
