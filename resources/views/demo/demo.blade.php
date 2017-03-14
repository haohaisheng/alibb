<!DOCTYPE html>
<html>
<head>
    @include('Pc.common.head')
    <meta charset="utf-8"/>
    <meta name="_token" content="{{csrf_token()}}"/>
    <script charset="utf-8" src="{{ URL::asset('assets/js/utils.js') }}"></script>
    <script charset="utf-8" src="{{ URL::asset('assets/js/statis.js') }}"></script>
    <script charset="utf-8" src="{{ URL::asset('assets/plugins/vue.js') }}"></script>
    <script charset="utf-8" src="{{ URL::asset('assets/plugins/vue-resource/dist/vue-resource.js') }}"></script>
    <style>
        ul, li {
            margin: 0px;
            padding: 0px;
        }

        li {
            list-style: none
        }

        .page-bar li:first-child > a {
            margin-left: 0px
        }

        .page-bar a {
            border: 1px solid #ddd;
            text-decoration: none;
            position: relative;
            float: left;
            padding: 6px 12px;
            margin-left: -1px;
            line-height: 1.42857143;
            color: #337ab7;
            cursor: pointer
        }

        .page-bar a:hover {
            background-color: #eee;
        }

        .page-bar .active a {
            color: #fff;
            cursor: default;
            background-color: #337ab7;
            border-color: #337ab7;
        }
    </style>
</head>
<body>

@include('Pc.common.header')
        <!--top-->
<div class="boxx m_t_15">
    <!--主左-->
    <div class="boxx845">
        <div class="zt_a">
            <div id="app">
                <ul class="ind_a">
                    <li v-for="list in lists">
                        {{--<template v-for="d in todo.data">--}}
                        <a href="#">
                            <img src="http://pic.sameboy.com/Public/uploadfiles/member/2015-10/20151026161312_big.jpg"
                                 width="100">
                        </a>

                        <div class="ind_a2">
                            <a href="#"><strong></strong></a><strong><a href="#1"
                                                                        onclick="questionPage('503')">@{{list.title}}</a></strong><span
                                    class="ind_a21">来自  <a href="http://www.sameboy.com/special/277">
                                    <i class="tlq_lan">@{{list.specialname }}</i></a> 专题</span>

                            <div class="ind_a22"><a href="#"><i class="tlq_lan">@{{list.nickname}}
                                        &nbsp;&nbsp;</i></a>@{{list.add_time}}&nbsp;&nbsp;发起了问题
                            </div>
                            <p><a href="#1" onclick="questionPage('503')">@{{list.content}}</a>
                            </p>

                            <div class="ind_a24" style="padding-right: 0px"><i
                                        class="tlq_lan">@{{list.view_count}}</i>
                                浏览<i class="tlq_lan"> @{{list.focus_count}}</i> 人关注 <i
                                        class="tlq_lan">@{{list.answer_count}}</i> 人回复
                            </div>
                            <a style="cursor:pointer">
                                    <span v-if="list.isfocus" id="@{{list.question_id}}|@{{list.special_id}}"
                                          class="a_guanzhu_qx"
                                          v-on:click="focus">取消</span>
                                     <span v-else id="@{{list.question_id}}|@{{list.special_id}}"
                                           class="a_guanzhu"
                                           v-on:click="focus">关注</span>
                            </a>
                        </div>
                        {{-- </template>--}}
                    </li>
                </ul>
                <div class="page-bar">
                    <ul>
                        <li v-if="showFirst"><a v-on:click="cur--">上一页</a></li>
                        <li v-for="index in indexs" v-bind:class="{ 'active': cur == index}">
                            <a v-on:click="btnClick(index)">@{{ index }}</a>
                        </li>
                        <li v-if="showLast"><a v-on:click="cur++">下一页</a></li>
                        <li><a>共<i>@{{all}}</i>页</a></li>
                    </ul>
                </div>
            </div>
        </div>
    </div>
    <!--主右-->
    <div class="boxx315">
        @include('Pc.common.right_memberinfo')
    </div>
    <br class="clr"/>
</div>
@include('Pc.common.footer')
        <!--    <script charset="utf-8" type="text/babel" src="{{ URL::asset('pc/js/demo.js') }}"></script> -->
</body>
<script>
    //Vue.http.options.emulateJSON = true;
    var vm = new Vue({
        http: {
            headers: {
                'X-CSRF-TOKEN': $('meta[name="_token"]').attr('content')
            },
        },
        el: '#app',
        data: {
            classObject: {
                'a_guanzhu': true,
                'a_guanzhu_qx': false
            },
            lists: '',
            all: '',
            cur: 1,
        },
        ready: function () {
            this.btnClick(this.cur);
        },
        computed: {
            indexs: function () {
                var left = 1
                var right = this.all
                var ar = []
                if (this.all >= 11) {
                    if (this.cur > 5 && this.cur < this.all - 4) {
                        left = this.cur - 5
                        right = this.cur + 4
                    } else {
                        if (this.cur <= 5) {
                            left = 1
                            right = 10
                        } else {
                            right = this.all
                            left = this.all - 9
                        }
                    }
                }
                while (left <= right) {
                    ar.push(left)
                    left++
                }
                return ar
            },
            showLast: function () {
                if (this.cur == this.all) {
                    return false
                }
                return true
            },
            showFirst: function () {
                if (this.cur == 1) {
                    return false
                }
                return true
            }
        },
        methods: {
            focus: function (event) {
                senddata = {
                    questionid: event.target.id.split('|')[0],
                    speicalid: event.target.id.split('|')[1]
                };
                this.$http.post('demoupdate1', senddata, function (data) {
                    if (eval(data).code) {
                        Alert(eval(data).msg);
                        event.target.className = "a_guanzhu_qx";
                    }
                }).error(function (data, status, request) {
                    console.log('fail' + status + "," + request);
                })
            },
            btnClick: function (index) {
                /* if (index != this.cur) {
                 this.cur = index;
                 }*/
                this.cur = index;
                senddata = {page: index};
                this.$http.get('demoList', senddata, function (data) {
                    if (this.cur == 1) {
                        this.$set('lists', eval(JSON.stringify(data.data)));
                    } else {
                        var aa = eval(JSON.stringify(this.lists));
                        var bb = eval(JSON.stringify(data.data));
                        var cc = aa.concat(bb);
                        this.$set('lists', cc);
                    }
                    this.$set('all', eval(JSON.stringify(data.last_page)));
                }).error(function (data, status, request) {
                    console.log('fail' + status + "," + request);
                })
            }
        },
        watch: {
            cur: function (oldValue, newValue) {
                console.log(arguments)
            }
        }
    })
</script>
</html>
