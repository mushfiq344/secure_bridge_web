<div id="chat_box" class="chat_box pull-right shadow-lg p-3 mb-5 bg-white rounded" style="display: none;">
    <div class="row">
        <div class="col-xs-12 col-md-12">
            <div class="panel panel-default">
                <div class="panel-heading px-4 py-4  gradient-background">
                    <h3 class="panel-title text-light"><span class="glyphicon glyphicon-comment"></span> Chat with <i class="chat-user"></i> </h3>
                    <i class="fa fa-close pull-right close-chat" style="color:#fff"></i>
                </div>
                <div class="panel-body chat-area px-4 py-4">

                </div>
                <div class="panel-footer">
                    <div class="input-group form-controls">
                        <textarea class="form-control input-sm chat_input" placeholder="Write your message here..."></textarea>
                        <span class="input-group-btn">
                            <button class="btn btn-primary btn-sm btn-chat" type="button" data-to-user="" disabled>
                                <i class="fa fa-send"></i>
                                Send</button>
                        </span>
                    </div>
                </div>
            </div>
        </div>
    </div>
    <input type="hidden" id="to_user_id" value="" />
</div>