<div class="block block-xl">
		<div class="container">
				<h1>$Ticket.Title</h1>
				<strong>Status:</strong> $Ticket.Status<br />
				<strong>Created at:</strong> $Ticket.Created.Nice<br />
				<strong>Created by:</strong> $Ticket.Member.Name<br />
				<div class="mb-lg">
						$Ticket.Message
				</div>
				<h2>Comments</h2>
        <% if $Ticket.Comments %>
				<% loop $Ticket.Comments %>
				<div class="panel">
						<strong>Commenter:</strong> $Member.Name<% if $IsAdminComment %> (Admin)<% end_if %><br />
						<strong>Added on:</strong> $Created.Nice<br />
						$Comment
				</div>
				<% end_loop %>
        <% else %>
				<div class="alert">
						<%t HelpdeskTicket.NO_COMMENTS_YET "There are no comments (yet)" %>
				</div>
        <% end_if %>

        <% if $CurrentUser && $Ticket.IsOpen %>
				<h2>Add a comment</h2>
				$CommentTicketForm
        <% else_if not $Ticket.IsOpen %>
				<div class="alert"><%t HelpdeskTicket.TICKET_CLOSED "You can't add comments anymore because this ticket is closed" %></div>
        <% else %>
				<div class="alert"><%t HelpdeskTicket.NEED_TO_BE_LOGGEDIN "You need to be logged in to add a comment" %></div>
				<a href="$LoginLink($Ticket.Link)" class="btn">Login</a>
        <% end_if %>
		</div>
</div>