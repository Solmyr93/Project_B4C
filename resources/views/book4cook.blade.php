<!DOCTYPE html>
<html lang="en">
<head>
    <title>Book 4 Cook</title>
    <link href='https://fonts.googleapis.com/css?family=Roboto:400,300,700' rel='stylesheet' type='text/css'>
    <script src="/assets/js/core/pace.js"></script>
    <link href="{{mix("/assets/css/laraspace.css")}}" rel="stylesheet" type="text/css">
    <meta name="viewport" content="width=device-width,initial-scale=1">
    <link rel="shortcut icon" href="{{{ asset('img/favicons/favicon.png') }}}">
</head>
<body class="layout-default skin-default">
<div id="book4cook" class="template-container">
    <div class="mobile-menu-overlay" v-on:click.prevent="onOverlayClick"></div>
    <transition name="fade" mode="out-in">
        <router-view></router-view>
    </transition>
</div>
<script type="text/javascript" src="{{mix('/assets/js/core/plugins.js')}}"></script>
<script type="text/javascript" src="{{mix('/assets/js/book4cookApp.js')}}"></script>
</body>
</html>
