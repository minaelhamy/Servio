<div id="sales-booster-popup"
    class="animation-slide_right {{ helper::appdata($vendordata->id)->sales_notification_position == '2' ? 'rtl' : '' }} rounded-3 d-none d-lg-block">
    <span class="close z-1 pos-absolute top {{ session()->get('direction') == '2' ? 'left' : 'right' }}">
        <i class="fa-light fa-xmark color-changer"></i>
    </span>
    <div class="sales-booster-popup-inner gap-2 card" id="notification_body">

    </div>
</div>
