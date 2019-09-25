News.tpl
{$module->getDir()}
{$module->getKeys().print_r()}
{$module->getFullName()}
{ddset $i=1}

{for from=0 to=10 key=$i}
{$i}
{include "name_1.tpl"}
{include "name_2.tpl"}

{/for}
