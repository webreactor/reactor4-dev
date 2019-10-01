News.tpl

{@module->getDir()}
{@module->getFullName()}
{foreach from=@module->getKeys() item=@key}
Key: {@key}
{/foreach}

{foreach from=$data.data item=@line}
*{@line.title} {echo date('r', @line.dtime)}*
 {@line.preview}
{/foreach}
