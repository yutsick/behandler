<?php

namespace Routiz\Inc\Src\Form\Modules\Editor;

use \Routiz\Inc\Src\Form\Modules\Module;

class Editor extends Module {

    public function controller() {

        return array_merge( (array) $this->props, [
            'editor_id' => $this->props->id,
            'is_admin' => is_admin() and ! wp_doing_ajax(),
        ]);

    }

}
