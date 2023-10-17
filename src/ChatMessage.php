<?php

namespace Ragab\ChatMessage;

use Laravel\Nova\ResourceTool;

class ChatMessage extends ResourceTool
{
    /**
     * Get the displayable name of the resource tool.
     *
     * @return string
     */
    public function name()
    {
        return 'Chat Message';
    }

    public function messages($messages = null)
    {
        return $this->withMeta(['messages' => $messages]);
    }

    /**
     * Get the component name for the resource tool.
     *
     * @return string
     */
    public function component()
    {
        return 'chat-message';
    }
}
