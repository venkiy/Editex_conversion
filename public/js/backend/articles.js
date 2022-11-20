(function () {

    FTX.Articles = {

        list: {

            selectors: {
                articles_table: $('#articles-table'),
            },

            init: function (pageName) {

                var data = {};

                if (pageName == 'active') {
                    data = { status: 1, trashed: false };
                } else {
                    data = { status: 0, trashed: false };
                }

                this.selectors.articles_table.dataTable({

                    processing: false,
                    serverSide: true,
                    ajax: {
                        url: this.selectors.articles_table.data('ajax_url'),
                        type: 'post',
                        data: data
                    },
                    columns: [

                        { data: 'publisher_id', name: 'publisher_id' },
                        { data: 'publisher_name', name: 'publisher_name' },
                        { data: 'article_id', name: 'article_id' },
                        { data: 'noecs', name: 'noecs' },
                        { data: 'galleypdf', name: 'galleypdf' },
                        { data: 'galleyproofpdf', name: 'galleyproofpdf' },
                        { data: 'status', name: 'status', sortable: false },                        
                        { data: 'actions', name: 'actions', searchable: false, sortable: false }
                    ],
                    order: [[0, "asc"]],
                    searchDelay: 500,
                    "createdRow": function (row, data, dataIndex) {
                        FTX.Utils.dtAnchorToForm(row);
                    }
                })
            }
        },

        edit: {
            selectors: {
                getPremissionURL: "",
                getRoleForPermissions: "",
                getAvailabelPermissions: "",
                Role3: "",
                searchButton: "",
            },
            init: function (pageName) {
                this.setSelectors();
                this.addHandlers(pageName);
            },
            setSelectors: function () {
                this.selectors.getRoleForPermissions = document.querySelectorAll(".get-role-for-permissions");
                this.selectors.getAvailabelPermissions = document.querySelector(".get-available-permissions");
                this.selectors.searchButton = document.querySelector(".search-button");
                this.selectors.Role3 = document.getElementById("role-3");
            },
            addHandlers: function (pageName) {

                this.selectors.getRoleForPermissions.forEach(function (element) {
                    element.onclick = function (event) {

                        FTX.Articles.edit.selectors.searchButton.value = '';
                        FTX.Utils.addClass(FTX.Articles.edit.selectors.searchButton, 'hidden');
                        // FTX.Articles.edit.selectors.searchButton.dispatchEvent(new Event('keyup'));

                        FTX.Utils.addClass(document.getElementById("available-permissions"), 'hidden');

                        callback = {
                            success: function (request) {
                                if (request.status >= 200 && request.status < 400) {
                                    // Success!
                                    var response = JSON.parse(request.responseText);
                                    var permissions = response.permissions;
                                    var rolePermissions = response.rolePermissions;
                                    var allPermisssions = response.allPermissions;

                                    FTX.Articles.edit.selectors.getAvailabelPermissions.innerHTML = "";
                                    htmlstring = "";
                                    if (permissions.length == 0) {
                                        FTX.Articles.edit.selectors.getAvailabelPermissions.innerHTML = '<p>There are no available permissions.</p>';
                                    } else {
                                        for (var key in permissions) {
                                            var addChecked = '';
                                            if (allPermisssions == 1 && rolePermissions.length == 0) {
                                                addChecked = 'checked="checked"';
                                            } else {
                                                if (typeof rolePermissions[key] !== "undefined") {
                                                    addChecked = 'checked="checked"';
                                                }
                                            }

                                            htmlstring += '<div><input type="checkbox" name="permissions[' + key + ']" value="' + key + '" id="perm_' + key + '" ' + addChecked + '/><label for="perm_' + key + '" style="margin-left:10px;">' + permissions[key] + '</label></div>';
                                        }
                                    }
                                    FTX.Articles.edit.selectors.getAvailabelPermissions.innerHTML = htmlstring;
                                    FTX.Utils.removeClass(document.getElementById("available-permissions"), 'hidden');
                                    FTX.Utils.removeClass(FTX.Articles.edit.selectors.searchButton, 'hidden');

                                } else {
                                    // We reached our target server, but it returned an error
                                    FTX.Articles.edit.selectors.getAvailabelPermissions.innerHTML = '<p>There are no available permissions.</p>';
                                }
                            },
                            error: function () {
                                FTX.Articles.edit.selectors.getAvailabelPermissions.innerHTML = '<p>There are no available permissions.</p>';
                            }
                        };

                        FTX.Utils.ajaxrequest(FTX.Articles.edit.selectors.getPremissionURL, "post", {
                            role_id: event.target.value
                        }, FTX.Utils.csrf, callback);
                    };
                });

                this.selectors.searchButton.addEventListener('keyup', function (e) {

                    var searchTerm = this.value.toLowerCase();

                    FTX.Articles.edit.selectors.getAvailabelPermissions.children.forEach(function (el) {

                        var shouldShow = true;

                        searchTerm.split(" ").forEach(function (val) {
                            if (shouldShow && (el.querySelector('label').innerHTML.toLowerCase().indexOf(val) == -1)) {
                                shouldShow = false;
                            }
                        });

                        if (shouldShow) {
                            FTX.Utils.removeClass(el, 'hidden');
                        } else {
                            FTX.Utils.addClass(el, 'hidden');
                        }
                    });
                });

                if (pageName == "create") {
                    FTX.Articles.edit.selectors.Role3.click();
                }
            },
        },
    }
})();