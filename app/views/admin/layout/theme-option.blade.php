<div class="theme-panel hidden-xs hidden-sm">
    <div class="toggler" style="display: block;">
    </div>
    <div class="toggler-close" style="display: none;">
    </div>
    <div class="theme-options" style="display: none;">
        <div class="theme-option theme-colors clearfix">
            <span>
            THEME COLOR </span>
            <ul>
                @foreach(['Default', 'Dark Blue', 'Blue', 'Light', 'Light 2'] as $theme)
                <?php $themeKey = str_replace(' ', '', strtolower($theme)); ?>
                <li class="color-{{ $themeKey }} tooltips {{ isset($currentTheme['color']) && $currentTheme['color'] == $themeKey ? 'current' : '' }}" data-style="{{ $themeKey }}"  data-container="body" data-original-title="{{ $theme }}">
                </li>
                @endforeach
            </ul>
        </div>
        <div class="theme-option">
            <span>
            Theme Style </span>
            <select class="layout-style-option form-control input-sm">
                @foreach(['square' => 'Square corners', 'rounded' => 'Rounded corners'] as $style => $styleText)
                <option value="{{ $style }}" {{ isset($currentTheme['style']) && str_replace(['components', '-'], '', $currentTheme['style']) == str_replace('square', '', $style) ? 'selected' : '' }}>{{ $styleText }}</option>
                @endforeach
            </select>
        </div>
        <div class="theme-option">
            <span>
            Sidebar Mode</span>
            <select class="sidebar-option form-control input-sm">
                @foreach(['fixed' => 'Fixed', 'default' => 'Default'] as $sidebar => $sidebarText)
                <option value="{{ $sidebar }}" {{ isset($currentTheme['sidebar']) && $currentTheme['sidebar'] == $sidebar ? 'selected' : '' }}>{{ $sidebarText }}</option>
                @endforeach
            </select>
        </div>
        <div class="theme-option">
            <span>
            Footer</span>
            <select class="page-footer-option form-control input-sm">
                @foreach(['fixed' => 'Fixed', 'default' => 'Default'] as $sidebar => $sidebarText)
                <option value="{{ $sidebar }}" {{ isset($currentTheme['sidebar']) && $currentTheme['sidebar'] == $sidebar ? 'selected' : '' }}>{{ $sidebarText }}</option>
                @endforeach
            </select>
        </div>
    </div>
</div>
@section('pageJS')
<script type="text/javascript">
$('.theme-options .theme-colors li').click(function(){
    changeTheme('color', $(this).data('style'));
});
$('.theme-options .theme-option select.layout-style-option').change(function(){
    changeTheme('style', $(this).val());
});
$('.theme-options .theme-option select.sidebar-option').change(function(){
    changeTheme('sidebar', $(this).val());
});
$('.theme-options .theme-option select.page-footer-option').change(function(){
    changeTheme('footer', $(this).val());
});

function changeTheme(type, value)
{
    $.ajax({
        url: "{{ URL.'/admin/admins/change-theme' }}",
        data: {type: type, value: value},
        type: "POST",
        success: function(result){
            if( result.status == "error" ) {
                toastr.error(result.message, "Error");
            }
        }
    });
}
</script>
@append