<% cached 'faq', $LastEdited, $ID %>
<div class="block">
		<div class="container">
				<h1>$Title</h1>
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
</div>
<% end_cached %>