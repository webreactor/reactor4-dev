News.tpl

{@template->module->getDir()}
{@template->module->getFullName()}
{foreach from=@template->module->getKeys() item=@key}
Key: {@key}
{/foreach}

{for from=0 to=10 key=@i}
{@i}
{include "name_1.tpl"}
{include "name_2.tpl"}
{/for}
