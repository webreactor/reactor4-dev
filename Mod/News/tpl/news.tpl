News.tpl

{@module->getDir()}
{@module->getFullName()}
{foreach from=@module->getKeys() item=@key}
Key: {@key}
{/foreach}


{foreach $data.data as @line}
*{@line.title} {echo date('r', @line.dtime)}*
 {@line.preview}
{/foreach}

Navigation:</br>
{navigation key=@key data=$data}
<a href="?page={@key}">{@key}</a></br>
{else}
{@key}</br>
{/navigation}
Total: {$data.total_rows}
