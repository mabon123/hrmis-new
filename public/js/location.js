$(function() {

    $(document).ready(function() {
        $.ajaxSetup({
            headers: {
                'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
            }
        });

        $("#p_code").change(function() {
            getChildrenLocation($(this).val(), `/provinces/${$(this).val()}/districts`, $('#d_code'), 'dis_code')
        });
        if ($("#p_code").attr('data-old-value')) {
            $("#p_code").val($("#p_code").attr('data-old-value'))
            $("#p_code").attr('data-old-value', '')
            $("#p_code").trigger('change')
        }

        $("#d_code").change(function() {
            getChildrenLocation($(this).val(), `/districts/${$(this).val()}/communes`, $('#c_code'), 'com_code')
        });

        $("#c_code").change(function() {
            getChildrenLocation($(this).val(), `/communes/${$(this).val()}/villages`, $('#v_code'), 'vil_code')
        });

        function getChildrenLocation(code, url, childSelector, key) {
            if (!childSelector.length) return

            var lang = $('html').attr('lang')
            var defaultOption = lang === 'en' ? '<option value="">Choose</option>' : '<option value="">ជ្រើសរើស</option>'

            if( code !== "" && code !== '9916' ) {

                childSelector.empty();
                childSelector.html(defaultOption);

                $.ajax({
                    type: "GET",
                    url: url,
                    success: function (locations) {
                        for(var index in locations) {
                            childSelector.append('<option value="'+locations[index][key]+'">'+ locations[index]['name_kh'] +'</option>');
                        }
                        
                        if (childSelector.attr('data-old-value')) {
                            childSelector.val(childSelector.attr('data-old-value')).trigger('change')
                            childSelector.attr('data-old-value', '')
                        } else if (childSelector.attr('data-selected')) {
                            childSelector.val(childSelector.attr('data-selected')).trigger('change')
                        }
                    },
                    error: function (err) {
                        console.log('Error:', err);
                    }
                });

                childSelector.prop("disabled", childSelector.data('disabled') || false);
            } else {
                childSelector.empty();
                childSelector.append(defaultOption);
                childSelector.prop("disabled", true);
            }

            childSelector.trigger('change')
        }
    })
});
