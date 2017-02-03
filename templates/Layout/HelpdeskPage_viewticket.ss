<div class="block">
	<div class="container">
        $Ticket.Status
        $Ticket.Title

        <% if $Ticket.Comments %>
            <% loop $Ticket.Comments %>
				<div>
                    $Member.Name
                    <% if $IsAdminComment %>Admin comment<% end_if %>
                    $Comment
				</div>
            <% end_loop %>
        <% else %>
            <%t HelpdeskTicket.NO_COMMENTS_YET "There are no comments (yet)" %>
        <% end_if %>

        <% if $CurrentUser && $Ticket.IsOpen %>
            $CommentTicketForm
        <% else_if not $Ticket.IsOpen %>
            <%t HelpdeskTicket.TICKET_CLOSED "You can't add comments anymore because this ticket is closed" %>
        <% else %>
            <%t HelpdeskTicket.NEED_TO_BE_LOGGEDIN "You need to be logged in to add a comment" %>
			<a href="$LoginLink($Ticket.Link)" class="btn">Login</a>
        <% end_if %>
	</div>
</div>