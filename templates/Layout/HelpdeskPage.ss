<div class="container">
	$Content
	<div class="row">
		<div class="col-md-8">
            <% if $PaginatedTickets %>
                <% loop $PaginatedTickets %>
					<div>
						<h2>$Status $Title</h2>
                        $Created $Member.Name <br/>
                        $Comments.Count
						<a href="$Link">view ticket</a>
					</div>
                <% end_loop %>
            <% else %>
				<p><%t HelpdeskTicket.NO_TICKETS_FOUND "No tickets found" %></p>
            <% end_if %>
		</div>
		<div class="col-md-4">
			<a href="$CreateTicketLink" class="btn"><%t HelpdeskTicket.CREATE_TICKET "Create ticket" %></a>
			filters op closed/open
			door issues kunnen zoeken
            <% if $PaginatedTickets %>
                <% include HelpdeskPagination List=$PaginatedTickets %>
            <% end_if %>
		</div>
	</div>
</div>