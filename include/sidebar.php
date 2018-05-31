<nav class="navbar-default navbar-side" role="navigation">
    <div class="sidebar-collapse">
        <ul class="nav" id="main-menu">

            <?php if ($objsession->get('log_admin_type') == 'admin') { ?>
                <li>
                    <a class="waves-effect waves-dark" href="<?php echo HTTP_SERVER; ?>"><i class="fa fa-dashboard"></i>
                        Dashboard</a>
                </li>
                <li>
                    <a href="#" class="waves-effect waves-dark"><i class="fa fa-user" aria-hidden="true"></i>
                        Manager<span
                                class="fa arrow"></span></a>
                    <ul class="nav nav-second-level">
                        <li>
                            <a href="<?php echo HTTP_SERVER; ?>appointments">Appointments</a>
                        </li>
                        <li>
                            <a href="<?php echo HTTP_SERVER; ?>usermanager">User Manager</a>
                        </li>
                        <li>
                            <a href="<?php echo HTTP_SERVER; ?>inquirymanager">Inquiry Manager</a>
                        </li>
                        <li>
                            <a href="<?php echo HTTP_SERVER; ?>clientsmanager">Clients Manager</a>
                        </li>
                    </ul>
                </li>
                <li>
                    <a href="#" class="waves-effect waves-dark"><i class="fa fa-user" aria-hidden="true"></i>
                        General Master<span
                                class="fa arrow"></span></a>
                    <ul class="nav nav-second-level side-ul-scroll">
                        <li>
                            <a href="<?php echo HTTP_SERVER; ?>maritalstatus">Marrital Status</a>
                        </li>
                        <li>
                            <a href="<?php echo HTTP_SERVER; ?>business">Business Type</a>
                        </li>
                        <li>
                            <a href="<?php echo HTTP_SERVER; ?>immigration">Immigration Status</a>
                        </li>
                        <li>
                            <a href="<?php echo HTTP_SERVER; ?>relationship">Relationship</a>
                        </li>
                        <li>
                            <a href="<?php echo HTTP_SERVER; ?>exammaster">English Proficiency Tests</a>
                        </li>
                        <li>
                            <a href="<?php echo HTTP_SERVER; ?>visamaster">Visa Master</a>
                        </li>
                        <li>
                            <a href="<?php echo HTTP_SERVER; ?>references">Referees</a>
                        </li>
                        <li>
                            <a href="<?php echo HTTP_SERVER; ?>proficiency">English Proficiency Level</a>
                        </li>
                        <li>
                            <a href="<?php echo HTTP_SERVER; ?>doctypes">Document Type Category</a>
                        </li>
                        <li>
                            <a href="<?php echo HTTP_SERVER; ?>visadocument">Visa Document List</a>
                        </li>
                        <li>
                            <a href="<?php echo HTTP_SERVER; ?>visitortypes">Main Purpose of Meeting</a>
                        </li>
                        <li>
                            <a href="<?php echo HTTP_SERVER; ?>appointmentpurpose">Specific Purpose of Meeting</a>
                        </li>
                        <li>
                            <a href="<?php echo HTTP_SERVER; ?>paymentstage">Payment Stage For Migration</a>
                        </li>
                        <li>
                            <a href="<?php echo HTTP_SERVER; ?>events">CPD Events</a>
                        </li>
                        <li>
                            <a href="<?php echo HTTP_SERVER; ?>migration">Reason for Name Change</a>
                        </li>
                        <li>
                            <a href="<?php echo HTTP_SERVER; ?>medium">Medium of Instructions</a>
                        </li>
                        <li>
                            <a href="<?php echo HTTP_SERVER; ?>workcomplete">Work Complete</a>
                        </li>
                        <li>
                            <a href="<?php echo HTTP_SERVER; ?>accounts">Account Type</a>
                        </li>
                        <li>
                            <a href="<?php echo HTTP_SERVER; ?>currency">Currency Type</a>
                        </li>
                    </ul>
                </li>
            <?php } else if ($objsession->get('log_admin_type') == 'subadmin') { ?>
                <li>
                    <a href="#" class="waves-effect waves-dark"><i class="fa fa-user" aria-hidden="true"></i> Users<span
                                class="fa arrow"></span></a>
                    <ul class="nav nav-second-level">
                        <li>
                            <a href="<?php echo HTTP_SERVER; ?>subadmin_users">List of User</a>
                        </li>
                        <li>
                            <a href="<?php echo HTTP_SERVER; ?>manageuser">Manage User</a>
                        </li>
                    </ul>
                </li>
            <?php } else if ($objsession->get('log_admin_type') == 'receptionist') { ?>
                <li>
                    <a href="#" class="waves-effect waves-dark"><i class="fa fa-user" aria-hidden="true"></i>
                        Manager<span
                                class="fa arrow"></span></a>
                    <ul class="nav nav-second-level">
                        <li>
                            <a href="<?php echo HTTP_SERVER; ?>appointments">Appointments</a>
                        </li>
                    </ul>
                </li>
            <?php } ?>
        </ul>
    </div>
</nav>
<!-- /. NAV SIDE  -->