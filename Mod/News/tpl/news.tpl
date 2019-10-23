News.tpl

{@module->getDir()}
{@module->getFullName()}
{foreach from=@module->getKeys() item=@key}
Key: {@key}
{/foreach}

{set $form = $web->form->buildFromYML('/news', 'form.yml')}

{$form.print_r()}

{foreach $data.data as @line}
*{@line.title} {echo date('r', @line.dtime)}*
 {@line.preview}
{/foreach}

Navigation:</br>
{set $link = '?page=__page__'}
{navigation key=@key data=$data frame=2}
<a href="{echo $web->url->build($req_res, array('page' => @key, 'test'=>1))}">{@key}</a></br>
{else}
{@key}</br>
{/navigation}
Total: {$data.total_rows}

