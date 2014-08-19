      <!-- Content Header (Page header) -->
      <section class="content-header">
            <h1>
                  <?php echo lang('create_user_heading');?>
                  <small><?php echo lang('create_user_subheading');?></small>
            </h1>
            <ol class="breadcrumb">
                  <li class="active"><?php echo lang('create_user_heading');?></li>
            </ol>
      </section><!-- /.Content Header -->
      <section class="content">
            <!-- Small boxes (Stat box) -->
            <div class="row">
                  <section class="col-lg-10">
                        <div class="box">
                              <div class="box-body table-responsive">
                                    <div id="infoMessage"><?php echo $message;?></div>

                                    <?php echo form_open("auth/create_user");?>

                                          <p>
                                                <?php echo lang('create_user_username_label', 'username');?> <br />
                                                <?php echo form_input($username);?>
                                          </p>
                                          
                                          <p>
                                                <?php echo lang('create_user_type_label', 'type');?> <br />
                                                <?php echo form_input($type);?>
                                          </p>

                                          <p>
                                                <?php echo lang('create_user_fname_label', 'first_name');?> <br />
                                                <?php echo form_input($first_name);?>
                                          </p>

                                          <p>
                                                <?php echo lang('create_user_lname_label', 'last_name');?> <br />
                                                <?php echo form_input($last_name);?>
                                          </p>

                                          <p>
                                                <?php echo lang('create_user_company_label', 'company');?> <br />
                                                <?php echo form_input($company);?>
                                          </p>

                                          <p>
                                                <?php echo lang('create_user_email_label', 'email');?> <br />
                                                <?php echo form_input($email);?>
                                          </p>

                                          <p>
                                                <?php echo lang('create_user_phone_label', 'phone');?> <br />
                                                <?php echo form_input($phone);?>
                                          </p>

                                          <p>
                                                <?php echo lang('create_user_password_label', 'password');?> <br />
                                                <?php echo form_input($password);?>
                                          </p>

                                          <p>
                                                <?php echo lang('create_user_password_confirm_label', 'password_confirm');?> <br />
                                                <?php echo form_input($password_confirm);?>
                                          </p>


                                          <p><?php echo form_submit('submit', lang('create_user_submit_btn'));?></p>

                                    <?php echo form_close();?>
                              </div>
                        </div>
                  </section>
            </div>
    </section>