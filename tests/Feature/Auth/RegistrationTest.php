<?php

test('generic user registration is disabled', function () {
    $response = $this->get('/register');

    $response->assertNotFound();
});

test('company registration screen can be rendered', function () {
    $response = $this->get('/empresa/register');

    $response->assertOk();
});
