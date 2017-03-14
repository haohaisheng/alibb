<div class="row">
    <div class="col-md-12">
        <!-- BEGIN VALIDATION STATES-->
        <div class="portlet box green">
            <div class="portlet-title">
                <div class="caption"><i class="fa fa-reorder"></i>Advance Validation</div>
                <div class="tools">
                    <a href="javascript:;" class="collapse"></a>
                    <a href="#portlet-config" data-toggle="modal" class="config"></a>
                    <a href="javascript:;" class="reload"></a>
                    <a href="javascript:;" class="remove"></a>
                </div>
            </div>
            <div class="portlet-body form">
                <!-- BEGIN FORM-->
                <form action="#" id="form_sample_3" class="form-horizontal" novalidate="novalidate">
                    <div class="form-body">
                        <h3 class="form-section">Advance validation.
                            <small>Custom radio buttons, checkboxes and Select2 dropdowns</small>
                        </h3>
                        <div class="alert alert-danger display-hide">
                            <button class="close" data-close="alert"></button>
                            You have some form errors. Please check below.
                        </div>
                        <div class="alert alert-success display-hide">
                            <button class="close" data-close="alert"></button>
                            Your form validation is successful!
                        </div>
                        <div class="form-group">
                            <label class="control-label col-md-3">Name<span class="required">*</span></label>

                            <div class="col-md-4">
                                <input type="text" name="name" data-required="1" class="form-control">
                            </div>
                        </div>
                        <div class="form-group">
                            <label class="col-md-3 control-label">Email Address<span class="required">*</span></label>

                            <div class="col-md-4">
                                <div class="input-group">
                                    <span class="input-group-addon"><i class="fa fa-envelope"></i></span>
                                    <input type="email" name="email" class="form-control" placeholder="Email Address">
                                </div>
                            </div>
                        </div>
                        <div class="form-group">
                            <label class="control-label col-md-3">Occupation&nbsp;&nbsp;</label>

                            <div class="col-md-4">
                                <input name="occupation" type="text" class="form-control">
                            </div>
                        </div>
                        <div class="form-group">
                            <label class="control-label col-md-3">Category<span class="required">*</span></label>

                            <div class="col-md-4">
                                <select class="form-control" name="category">
                                    <option value="">Select...</option>
                                    <option value="Category 1">Category 1</option>
                                    <option value="Category 2">Category 2</option>
                                    <option value="Category 3">Category 5</option>
                                    <option value="Category 4">Category 4</option>
                                </select>
                            </div>
                        </div>
                        <div class="form-group">
                            <label class="control-label col-md-3">Select2 Dropdown<span
                                        class="required">*</span></label>

                            <div class="col-md-4">
                                <div class="select2-container form-control select2me" id="s2id_form_2_select2"><a
                                            href="javascript:void(0)" onclick="return false;" class="select2-choice"
                                            tabindex="-1"> <span class="select2-chosen">Select...</span><abbr
                                                class="select2-search-choice-close"></abbr> <span class="select2-arrow"><b></b></span></a><input
                                            class="select2-focusser select2-offscreen" type="text" id="s2id_autogen1">

                                    <div class="select2-drop select2-display-none select2-with-searchbox">
                                        <div class="select2-search"><input type="text" autocomplete="off"
                                                                           autocorrect="off" autocapitalize="off"
                                                                           spellcheck="false" class="select2-input">
                                        </div>
                                        <ul class="select2-results"></ul>
                                    </div>
                                </div>
                                <select id="form_2_select2" class="form-control select2me select2-offscreen"
                                        name="options2" tabindex="-1">
                                    <option value="">Select...</option>
                                    <option value="Option 1">Option 1</option>
                                    <option value="Option 2">Option 2</option>
                                    <option value="Option 3">Option 3</option>
                                    <option value="Option 4">Option 4</option>
                                </select>
                            </div>
                        </div>
                        <div class="form-group">
                            <label class="control-label col-md-3">Membership<span class="required">*</span></label>

                            <div class="col-md-4">
                                <div class="radio-list" data-error-container="#form_2_membership_error">
                                    <label>
                                        <div class="radio"><span><input type="radio" name="membership" value="1"></span>
                                        </div>
                                        Fee
                                    </label>
                                    <label>
                                        <div class="radio"><span><input type="radio" name="membership" value="2"></span>
                                        </div>
                                        Professional
                                    </label>
                                </div>
                                <div id="form_2_membership_error"></div>
                            </div>
                        </div>
                        <div class="form-group">
                            <label class="control-label col-md-3">Services<span class="required">*</span></label>

                            <div class="col-md-4">
                                <div class="checkbox-list" data-error-container="#form_2_services_error">
                                    <label>
                                        <div class="checker"><span><input type="checkbox" value="1"
                                                                          name="service"></span></div>
                                        Service 1
                                    </label>
                                    <label>
                                        <div class="checker"><span><input type="checkbox" value="2"
                                                                          name="service"></span></div>
                                        Service 2
                                    </label>
                                    <label>
                                        <div class="checker"><span><input type="checkbox" value="3"
                                                                          name="service"></span></div>
                                        Service 3
                                    </label>
                                </div>
                                <span class="help-block">(select at least two)</span>

                                <div id="form_2_services_error"></div>
                            </div>
                        </div>
                    </div>
                    <div class="form-actions fluid">
                        <div class="col-md-offset-3 col-md-9">
                            <button type="submit" class="btn green">Submit</button>
                            <button type="button" class="btn default">Cancel</button>
                        </div>
                    </div>
                </form>
                <!-- END FORM-->
            </div>
            <!-- END VALIDATION STATES-->
        </div>
    </div>
</div>