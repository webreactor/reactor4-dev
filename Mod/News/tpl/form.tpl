FORM:
{if $req_res->request->get.done.isset()}
THANK YOU
{else}
<form method="POST">
{foreach $data->fields as @name => @field}
    {@field->settings.caption}: <input type="text" name="{@name}" value="{@field->getData('toForm')}"><br>
    {if @field->isErrors()}
        {foreach @field->getErrors() as @error}
            <div style="color:red;">{@error}</div>
        {/foreach}
    {/if}
{/foreach}
<input type="submit" value="Save">
</form>
{/if}

