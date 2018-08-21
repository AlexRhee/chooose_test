/* =========================================================
 * pricingtable.js v1.0
 * ========================================================= */


(function ($) {
	

        var Shortcodes = vc.shortcodes;
        window.t_PricingTableView = vc.shortcode_view.extend({
            change_columns_layout: !1,
            events: {
                'click > .vc_controls [data-vc-control="delete"]': "deleteShortcode",
                "click > .vc_controls .set_columns": "setColumns",
                'click > .vc_controls [data-vc-control="add"]': "addElement",
                'click > .vc_controls [data-vc-control="edit"]': "editElement",
                'click > .vc_controls [data-vc-control="clone"]': "clone",
                'click > .vc_controls [data-vc-control="move"]': "moveElement",
                'click > .vc_controls [data-vc-control="toggle"]': "toggleElement",
                "click > .wpb_element_wrapper .vc_controls": "openClosedRow"
            },
            convertRowColumns: function(layout) {
                var layout_split = layout.toString().split(/_/),
                    columns = Shortcodes.where({
                        parent_id: this.model.id
                    }),
                    new_columns = [],
                    new_layout = [],
                    new_width = "";
                return _.each(layout_split, function(value, i) {
                    var new_column_params, new_column, column_data = _.map(value.toString().split(""), function(v, i) {
                        return parseInt(v, 10)
                    });
                    new_width = 3 < column_data.length ? column_data[0] + "" + column_data[1] + "/" + column_data[2] + column_data[3] : 2 < column_data.length ? column_data[0] + "/" + column_data[1] + column_data[2] : column_data[0] + "/" + column_data[1], new_layout.push(new_width), new_column_params = _.extend(_.isUndefined(columns[i]) ? {} : columns[i].get("params"), {
                        width: new_width
                    }), vc.storage.lock(), new_column = Shortcodes.create({
                        shortcode: this.getChildTag(),
                        params: new_column_params,
                        parent_id: this.model.id
                    }), _.isObject(columns[i]) && _.each(Shortcodes.where({
                        parent_id: columns[i].id
                    }), function(shortcode) {
                        vc.storage.lock(), shortcode.save({
                            parent_id: new_column.id
                        }), vc.storage.lock(), shortcode.trigger("change_parent_id")
                    }), new_columns.push(new_column)
                }, this), layout_split.length < columns.length && _.each(columns.slice(layout_split.length), function(column) {
                    _.each(Shortcodes.where({
                        parent_id: column.id
                    }), function(shortcode) {
                        vc.storage.lock(), shortcode.save({
                            parent_id: _.last(new_columns).id
                        }), vc.storage.lock(), shortcode.trigger("change_parent_id")
                    })
                }), _.each(columns, function(shortcode) {
                    vc.storage.lock(), shortcode.destroy()
                }, this), this.model.save(), this.setActiveLayoutButton("" + layout), new_layout
            },
            changeShortcodeParams: function(model) {
                window.VcRowView.__super__.changeShortcodeParams.call(this, model), this.buildDesignHelpers()
            },
            designHelpersSelector: "> .vc_controls .column_toggle",
            buildDesignHelpers: function() {
                var css, $elementToPrepend, image, color, rowId, matches;
                css = this.model.getParam("css"), $elementToPrepend = this.$el.find(this.designHelpersSelector), this.$el.find("> .vc_controls .vc_row_color").remove(), this.$el.find("> .vc_controls .vc_row_image").remove(), matches = css.match(/background\-image:\s*url\(([^\)]+)\)/), matches && !_.isUndefined(matches[1]) && (image = matches[1]), matches = css.match(/background\-color:\s*([^\s\;]+)\b/), matches && !_.isUndefined(matches[1]) && (color = matches[1]), matches = css.match(/background:\s*([^\s]+)\b\s*url\(([^\)]+)\)/), matches && !_.isUndefined(matches[1]) && (color = matches[1], image = matches[2]), rowId = this.model.getParam("el_id"), this.$el.find("> .vc_controls .vc_row-hash-id").remove(), _.isEmpty(rowId) || $('<span class="vc_row-hash-id"></span>').text("#" + rowId).insertAfter($elementToPrepend), image && $('<span class="vc_row_image" style="background-image: url(' + image + ');" title="' + window.i18nLocale.row_background_image + '"></span>').insertAfter($elementToPrepend), color && $('<span class="vc_row_color" style="background-color: ' + color + '" title="' + window.i18nLocale.row_background_color + '"></span>').insertAfter($elementToPrepend)
            },
            addElement: function(e) {
                e && e.preventDefault(), Shortcodes.create({
                    shortcode: this.getChildTag(),
                    params: {},
                    parent_id: this.model.id
                }), this.setActiveLayoutButton(), this.$el.removeClass("vc_collapsed-row")
            },
            getChildTag: function() {
                return "t_pricing_table" === this.model.get("shortcode") ? "t_plan" : "t_plan"
            },
            sortingSelector: "> [data-element_type=vc_column], > [data-element_type=vc_column_inner]",
            sortingSelectorCancel: ".vc-non-draggable-column",
            setSorting: function() {
                var that = this;
                1 < this.$content.find(this.sortingSelector).length ? this.$content.removeClass("wpb-not-sortable").sortable({
                    forcePlaceholderSize: !0,
                    placeholder: "widgets-placeholder-column",
                    tolerance: "pointer",
                    cursor: "move",
                    items: this.sortingSelector,
                    cancel: this.sortingSelectorCancel,
                    distance: .5,
                    start: function(event, ui) {
                        $("#visual_composer_content").addClass("vc_sorting-started"), ui.placeholder.width(ui.item.width())
                    },
                    stop: function(event, ui) {
                        $("#visual_composer_content").removeClass("vc_sorting-started")
                    },
                    update: function() {
                        var $columns = $(that.sortingSelector, that.$content);
                        $columns.each(function() {
                            var model = $(this).data("model"),
                                index = $(this).index();
                            model.set("order", index), $columns.length - 1 > index && vc.storage.lock(), model.save()
                        })
                    },
                    over: function(event, ui) {
                        ui.placeholder.css({
                            maxWidth: ui.placeholder.parent().width()
                        }), ui.placeholder.removeClass("vc_hidden-placeholder")
                    },
                    beforeStop: function(event, ui) {}
                }) : (this.$content.hasClass("ui-sortable") && this.$content.sortable("destroy"), this.$content.addClass("wpb-not-sortable"))
            },
            validateCellsList: function(cells) {
                var b, return_cells = [],
                    split = cells.replace(/\s/g, "").split("+"),
                    sum = _.reduce(_.map(split, function(c) {
                        if (c.match(/^(vc_)?span\d?$/)) {
                            var converted_c = vc_convert_column_span_size(c);
                            return !1 === converted_c ? 1e3 : (b = converted_c.split(/\//), return_cells.push(b[0] + "" + b[1]), 12 * parseInt(b[0], 10) / parseInt(b[1], 10))
                        }
                        return c.match(/^[1-9]|1[0-2]\/[1-9]|1[0-2]$/) ? (b = c.split(/\//), return_cells.push(b[0] + "" + b[1]), 12 * parseInt(b[0], 10) / parseInt(b[1], 10)) : 1e4
                    }), function(num, memo) {
                        return memo += num
                    }, 0);
                return 12 !== sum ? !1 : return_cells.join("_")
            },
            setActiveLayoutButton: function(column_layout) {
                column_layout || (column_layout = _.map(vc.shortcodes.where({
                    parent_id: this.model.get("id")
                }), function(model) {
                    var width = model.getParam("width");
                    return width ? width.replace(/\//, "") : "11"
                }).join("_")), this.$el.find("> .vc_controls .vc_active").removeClass("vc_active");
                var $button = this.$el.find('> .vc_ [data-cells-mask="' + vc_get_column_mask(column_layout) + '"] [data-cells="' + column_layout + '"], > .vc_controls [data-cells-mask="' + vc_get_column_mask(column_layout) + '"][data-cells="' + column_layout + '"]');
                $button.length ? $button.addClass("vc_active") : this.$el.find("> .vc_controls [data-cells-mask=custom]").addClass("vc_active")
            },
            layoutEditor: function() {
                return _.isUndefined(vc.row_layout_editor) && (vc.row_layout_editor = new vc.RowLayoutUIPanelBackendEditor({
                    el: $("#vc_ui-panel-row-layout")
                })), vc.row_layout_editor
            },
            setColumns: function(e) {
                _.isObject(e) && e.preventDefault();
                var $button = $(e.currentTarget);
                if ("custom" === $button.data("cells")) this.layoutEditor().render(this.model).show();
                else {
                    if (vc.is_mobile) {
                        var $parent = $button.parent();
                        $parent.hasClass("vc_visible") || ($parent.addClass("vc_visible"), $(document).off("click.vcRowColumnsControl").on("click.vcRowColumnsControl", function(e) {
                            $parent.removeClass("vc_visible")
                        }))
                    }
                    $button.is(".vc_active") || (this.change_columns_layout = !0, _.defer(function(view, cells) {
                        view.convertRowColumns(cells)
                    }, this, $button.data("cells")))
                }
                this.$el.removeClass("vc_collapsed-row")
            },
            sizeRows: function() {
                var max_height = 45;
                $("> .wpb_vc_column, > .wpb_vc_column_inner", this.$content).each(function() {
                    var content_height = $(this).find("> .wpb_element_wrapper > .wpb_column_container").css({
                        minHeight: 0
                    }).height();
                    content_height > max_height && (max_height = content_height)
                }).each(function() {
                    $(this).find("> .wpb_element_wrapper > .wpb_column_container").css({
                        minHeight: max_height
                    })
                })
            },
            ready: function(e) {
                return window.VcRowView.__super__.ready.call(this, e), this
            },
            checkIsEmpty: function() {
                window.VcRowView.__super__.checkIsEmpty.call(this), this.setSorting()
            },
            changedContent: function(view) {
                return this.change_columns_layout ? this : void this.setActiveLayoutButton()
            },
            moveElement: function(e) {
                e.preventDefault()
            },
            toggleElement: function(e) {
                e && e.preventDefault(), this.$el.toggleClass("vc_collapsed-row")
            },
            openClosedRow: function(e) {
                this.$el.removeClass("vc_collapsed-row")
            },
            remove: function() {
                this.$content && this.$content.data("uiSortable") && this.$content.sortable("destroy"), this.$content && this.$content.data("uiDroppable") && this.$content.droppable("destroy"), delete vc.app.views[this.model.id], window.VcRowView.__super__.remove.call(this)
            }
		});	
	
})(window.jQuery);