<?php

test('the home page redirects to the posts index', function () {
    $this->get('/')->assertRedirect(route('posts.index'));
});

test('the posts index returns a successful response', function () {
    $this->get('/posts')->assertOk();
});
