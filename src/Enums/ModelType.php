<?php

namespace PDFfiller\LiteLLMClient\Enums;

enum ModelType: string
{
    case gpt4 = "gpt-4";
    case gpt4mini = "gpt-4o-mini";
    case gpt3 = "gpt-3.5-turbo";
}
