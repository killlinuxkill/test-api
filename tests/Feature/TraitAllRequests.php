<?php

namespace Tests\Feature;

trait TraitAllRequests
{
    // INDEX
    public function test_en_index()
    {
        $this->requestIndex();
    }

    public function test_ua_index()
    {
        $this->requestIndex('ua');
    }

    public function test_ru_index()
    {
        $this->requestIndex('ru');
    }

    // STORE
    public function test_en_store()
    {
        $this->requestStore('en');
    }

    public function test_ua_store()
    {
        $this->requestStore('ua');
    }

    public function test_ru_store()
    {
        $this->requestStore('ru');
    }

    // SHOW

    public function test_en_show()
    {
        $this->requestShow('en');
    }

    public function test_ua_show()
    {
        $this->requestShow('ua');
    }

    public function test_ru_show()
    {
        $this->requestShow('ru');
    }

    // UPDATE

    public function test_en_update()
    {
        $this->requestUpdate('en');
    }

    public function test_ua_update()
    {
        $this->requestUpdate('ua');
    }

    public function test_ru_update()
    {
        $this->requestUpdate('ru');
    }

    // DELETE

    public function test_en_delete()
    {
        $this->requestDestroy('en');
    }

    public function test_ua_delete()
    {
        $this->requestDestroy('ua');
    }

    public function test_ru_delete()
    {
        $this->requestDestroy('ru');
    }
}
