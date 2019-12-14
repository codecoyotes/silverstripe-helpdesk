<div class="block block-xl">
		<div class="container">
				<h1>$Title</h1>
        $Content
				<div class="row">
						<div class="col-md-8">
                <% if $PaginatedTickets %>
								<% loop $PaginatedTickets %>
								<div class="panel">
										<div class="panel-header">
												$Title
										</div>
										<div class="panel-body">
												<strong>Status:</strong> $Status<br />
												<strong>Created at:</strong> $Created.Nice<br />
												<strong>Created by:</strong> $Member.Name<br />
												<i class="fa fa-comment"></i> $Comments.Count Comments
										</div>
										<a href="$Link" class="btn panel-footer">view ticket</a>
								</div>
								<% end_loop %>
                <% else %>
								<div class="alert">
										<%t HelpdeskTicket.NO_TICKETS_FOUND "No tickets found" %>
								</div>
                <% end_if %>
						</div>
						<div class="col-md-4">
								<a href="$CreateTicketLink" class="btn btn-block"><%t HelpdeskTicket.CREATE_TICKET "Create ticket" %></a>
                <% if $PaginatedTickets %>
								<% include CodeCoyotes/Helpdesk/Includes/HelpdeskPagination List=$PaginatedTickets %>
                <% end_if %>
						</div>
				</div>
		</div>
</div>
