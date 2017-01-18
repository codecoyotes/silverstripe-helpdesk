<div class="container">
    $Content
    <% if $Categories %>
        <% loop $Categories %>
            <% if $Items %>
				<h2>$Title</h2>
                <% loop $Items %>
					<div>
						<h3>$Question</h3>
                        $Answer
					</div>
                <% end_loop %>
            <% end_if %>
        <% end_loop %>
    <% end_if %>
</div>