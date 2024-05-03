<div class="card-body p10 pt0">
    <?php
    //for assending mode, show the comment box at the top
    if (!$sort_as_decending) {
        foreach ($comments as $comment) {
            echo view("proposals/comment_row", array("comment" => $comment));
        }
    }
    ?>
    <div id="comment-form-container" class="b-t pt10">
        <?php echo form_open(get_uri("proposals/save_comment"), array("id" => "comment-form", "class" => "general-form", "role" => "form")); ?>
        <div class="d-flex">
            <div class="flex-shrink-0">
                <div class="avatar avatar-sm mr15">
                    <img src="<?php echo get_avatar($login_user->image); ?>" alt="..." />
                </div>
            </div>

            <div class="w-100">
                <div id="proposal-comment-dropzone" class="post-dropzone form-group">
                    <input type="hidden" name="proposal_id" value="<?php echo $proposal_info->id; ?>">
                    <?php
                    echo form_textarea(array(
                        "id" => "description",
                        "name" => "description",
                        "class" => "form-control",
                        "placeholder" => app_lang('write_a_comment'),
                        "data-rule-required" => true,
                        "data-msg-required" => app_lang("field_required"),
                        "data-rich-text-editor" => true,
                    ));
                    ?>
                    <?php echo view("includes/dropzone_preview"); ?>

                    <footer class="card-footer b-a clearfix d-flex">
                        <?php echo view("includes/upload_button"); ?>
                        <button class="btn btn-primary float-end btn-sm " type="submit"><i data-feather="send" class='icon-16'></i> <?php echo app_lang("post_comment"); ?></button>
                    </footer>
                </div>
            </div>
        </div>
        <?php echo form_close(); ?>
    </div>

    <?php
    //for decending mode, show the comment box at the bottom
    if ($sort_as_decending) {
        foreach ($comments as $comment) {
            echo view("proposals/comment_row", array("comment" => $comment));
        }
    }
    ?>

</div>

<script type="text/javascript">
    $(document).ready(function() {
        setProposalPreviewScrollable();
        $(window).resize(function() {
            setProposalPreviewScrollable();
        });

        var decending = "<?php echo $sort_as_decending; ?>";

        $("#comment-form").appForm({
            isModal: false,
            onSuccess: function(result) {
                $("#description").val("");

                if (decending) {
                    $(result.data).insertAfter("#comment-form-container");
                } else {
                    $(result.data).insertBefore("#comment-form-container");
                }

                appAlert.success(result.message, {
                    duration: 10000
                });

                if (window.formDropzone) {
                    window.formDropzone['proposal-comment-dropzone'].removeAllFiles();
                }
            }
        });
    });

    setProposalPreviewScrollable = function() {
        var options = {
            setHeight: $(window).height() - 85
        };
        initScrollbar('#proposal-comment-container', options);

        //don't apply scrollbar for mobile devices
        if ($(window).width() <= 640) {
            $('#proposal-preview-content').css({
                "overflow": "auto"
            });
        } else {
            initScrollbar("#proposal-preview-content", options);
        }
    };
</script>