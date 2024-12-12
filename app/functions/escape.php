<?php

function escapeHTML(mixed $value): string
{
    return htmlspecialchars($value, ENT_QUOTES, 'UTF-8');
}
function escapeTag(mixed $value): string
{
    return strip_tags($value);
}
