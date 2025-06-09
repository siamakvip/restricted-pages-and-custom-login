(function (wp) {
    var registerBlockType = wp.blocks.registerBlockType;
    var ToggleControl = wp.components.ToggleControl;
    var InspectorControls = wp.blockEditor.InspectorControls;
    var __ = wp.i18n.__;

    registerBlockType('custom-login-page/restricted-block', {
        title: __('محتوای خصوصی', 'custom-login-page'),
        icon: 'lock',
        category: 'common',
        edit: function (props) {
            var metaAttributes = wp.data.select('core/editor').getEditedPostAttribute('meta');
            var loginRequired = metaAttributes._clp_login_required || false;

            function onChangeLoginRequired(value) {
                wp.data.dispatch('core/editor').editPost({ meta: { _clp_login_required: value } });
            }

            return wp.element.createElement(
                InspectorControls,
                null,
                wp.element.createElement(
                    ToggleControl,
                    {
                        label: __('این محتوا فقط برای کاربران وارد شده قابل مشاهده باشد.', 'custom-login-page'),
                        checked: loginRequired,
                        onChange: onChangeLoginRequired
                    }
                )
            );
        },
        save: function () {
            return null;
        }
    });
})(window.wp);