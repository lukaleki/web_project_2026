<?php
class Storage {
    private $dir = "data/";

    public function __construct() {
        if (!is_dir($this->dir)) mkdir($this->dir, 0777, true);
        $this->initFile('users.json', []);
        $this->initFile('uploads.json', []);
        $this->initFile('tags.json', [
            ['id' => 1, 'name' => 'Document'],
            ['id' => 2, 'name' => 'Image'],
            ['id' => 3, 'name' => 'Archive']
        ]);
        $this->initFile('upload_tags.json', []);
    }

    private function initFile($filename, $defaultData) {
        if (!file_exists($this->dir . $filename)) {
            file_put_contents($this->dir . $filename, json_encode($defaultData));
        }
    }

    public function read($filename) {
        return json_decode(file_get_contents($this->dir . $filename), true);
    }

    public function write($filename, $data) {
        file_put_contents($this->dir . $filename, json_encode($data, JSON_PRETTY_PRINT));
    }
}
?>