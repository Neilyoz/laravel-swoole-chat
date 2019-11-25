@extends('layouts.app')

@section('content')
<div id="app" class="container">
    <div class="full-screen">
        <div class="mt-2 mb-2">
            <ul class="nav justify-content-end">
                <li class="nav-item">
                    <a class="nav-link" href="#">个人信息编辑</a>
                </li>
                <li class="nav-item">
                    <a class="nav-link" href="#">添加好友</a>
                </li>
                <li class="nav-item">
                    <a class="nav-link" href="#">创建群组</a>
                </li>
                <li class="nav-item">
                    <a class="nav-link" href="{{route('logout')}}">退出</a>
                </li>
            </ul>
        </div>
        <div class="d-flex">
            <div class="user-list border-left border-top border-bottom">
                <div class="user-item border-bottom" v-for="item in onlineList">
                    <img :src="item.head_pic" alt="">
                    <div class="username">
                        @{{item.username}}
                    </div>
                </div>
            </div>
            <div class="chat-container flex-grow-1 border">
                <div class="chat-content-list border-bottom">
                    <div v-for="item in chatList">
                        <div class="chat-self-item" v-if="isMySelf(item.user_id)">
                            <div class="chat-content-item mr-3">
                                @{{item.content}}
                            </div>
                            <div class="img-head-pic">
                                <img :src="item.head_pic" alt="">
                            </div>
                        </div>

                        <div class="chat-item" v-else>
                            <div class="img-head-pic mr-3">
                                <img :src="item.head_pic" alt="">
                            </div>
                            <div class="chat-content-item">
                                @{{item.content}}
                            </div>
                        </div>
                    </div>
                </div>
                <div class="chat-control p-3">
                    <div class="form-group">
                        <label for="chat-content">发送消息：</label>
                        <input type="email" class="form-control">
                    </div>
                    <div class="form-group">
                        <button type="submit" class="btn btn-primary">发送</button>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>
<script>
    $(function() {
        new Vue({
            el: '#app',
            data: {
                user_id: 2,
                onlineList: [
                    {
                        username: '后裔',
                        head_pic: '/img/169.jpg',
                    },
                    {
                        username: '鲁班',
                        head_pic: '/img/112.jpg',
                    }
                ],
                chatList: [
                    {
                        username: '后裔',
                        head_pic: '/img/169.jpg',
                        content: '小鲁班颤抖吧！',
                        user_id: 1,
                    },
                    {
                        username: '小鲁班',
                        head_pic: '/img/112.jpg',
                        content: '来呀，我还以为你不会和我玩儿了',
                        user_id: 2,
                    },
                    {
                        username: '小鲁班',
                        head_pic: '/img/112.jpg',
                        content: '一发炮弹就是嗒嗒嗒',
                        user_id: 2,
                    }
                ]
            },
            created: function() {
                console.log('创建成功');
            },

            methods: {
                isMySelf: function(user_id) {
                    return this.user_id === user_id;
                }
            }
        })
    });
</script>
@endsection
