<!-- User Account: style can be found in dropdown.less -->
<li class="dropdown user user-menu">
    <a href="#" class="dropdown-toggle" data-toggle="dropdown">
        <span class="icon">
            <i class="ion ion-person"> </i>
        </span>
        <span class="hidden-xs"> <?php echo e((isset(\Auth::user()->name)?\Auth::user()->name:'Logged In User')); ?></span>
    </a>
    <ul class="dropdown-menu">
        <!-- User image -->
        <li class="user-header">
            <?php if(isset(\Auth::user()->profile_pic)): ?>
                <img src="<?php echo e(config('app.app_public_path')); ?>img/user2-160x160.jpg" class="img-circle" alt="User Image">
            <?php else: ?>
                <div class="icon">
                    <i class="ion ion-person master_user_avatar"></i>
                </div>
            <?php endif; ?>
            <p>
                <?php echo e((isset(\Auth::user()->name)?\Auth::user()->name:'Logged In User')); ?> (<?php echo e((isset(\Auth::user()->name)?strtoupper(\Auth::user()->role):'')); ?>)
            </p>
        </li>

        <!-- Menu Footer-->
        <li class="user-footer">
            <div>
                <a href="<?php echo e(config('app.app_url_prefix')); ?>/logout" class="btn btn-default btn-flat">Log out</a>
            </div>
        </li>
    </ul>
</li>