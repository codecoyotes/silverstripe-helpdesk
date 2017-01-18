<% if $List.MoreThanOnePage %>
	<div class="toolbar flex-center">
		<div class="btn-group">
            <% loop $List.PaginationSummary(4) %>
                <% if $CurrentBool %>
					<span class="btn btn-light active">$PageNum</span>
                <% else %>
                    <% if $Link %>
						<a href="$Link<% if $Top.ExtraGetVar %>$Top.ExtraGetVar<% end_if %>"
						   class="btn btn-light">$PageNum</a>
                    <% else %>
						<span class="btn btn-light active">...</span>
                    <% end_if %>
                <% end_if %>
            <% end_loop %>
		</div>
	</div>
<% end_if %>