<script>

    /**
     * allow to refresh the table without reloading the page
     * reloading only a part of the DOM
     */
    function refreshDataTable( htmlId, urlListReload, viid) {
        $( "#area-"+htmlId).load( urlListReload+" #table-"+ htmlId ,function( ) {
            if( !viid ){
                table.destroy();
                loadDataTable( htmlId );
            }

        });
    }

    /**
     * function to delete a virtual/physical/vlan interface
     */
    function deletePopup( id, viid, type ){

        if( type == "vli"){
            objectName = "Vlan Interface";
            urlDelete = "<?= url( 'interfaces/vlan/delete' ) ?>";
        }
        else if( type == "vi" ){
            objectName = "Virtual Interface";
            urlDelete = "<?= url( 'interfaces/virtual/delete' ) ?>" ;
        }
        else if( type == "sflr" ){
            objectName = "Sflow Receiver";
            urlDelete = "<?= url( 'interfaces/sflow-receiver/delete' ) ?>" ;
        }
        else if( type == "pi" ){
            objectName = "Physical Interface";
            urlDelete = "<?= url( 'interfaces/physical/delete' ) ?>";
        }

        var reltype = "normal";

        if( $( '#delete-' +type+ '-' + id ).attr( "data-type" ) == 1 ){
            reltype = "fanout";
        } else if( $( '#delete-' +type+ '-' + id ).attr( "data-type" ) == 6 ){
            reltype = "peering";
        }

        var related = false;
        if( $( '#delete-' +type+ '-' + id ).attr( "data-related" ) ){
            related = true;
        }

        if( !related ) {
            bootbox.confirm({
                message: "Do you really want to delete this " + objectName + " ?" ,
                buttons: {
                    cancel: {
                        label: 'Cancel',
                        className: 'btn-primary'
                    },
                    confirm: {
                        label: 'Delete',
                        className: 'btn-danger'
                    }
                },
                callback: function ( result ) {
                    if( result) {
                        $.ajax( urlDelete + "/" + id,{
                            type : 'POST'
                        })
                            .done( function( data ) {
                                location.reload();
                            })
                            .fail( function(){
                                alert( 'Could add MAC address. API / AJAX / network error' );
                                throw new Error("Error running ajax query for " + urlDelete + "/" + id );
                            })
                    }
                }
            });
        } else {
            bootbox.dialog({
                title: "",
                message: "<b>Do you really want to delete this " +objectName+ " ? It has a related " + reltype + " interface.</b>",
                buttons: {
                    cancel: {
                        label: "Cancel",
                        className: 'btn-primary',
                        callback: function(){
                            return false;
                        }
                    },
                    deleteRelated: {
                        label: "Delete with related " + reltype + " interface ",
                        className: 'btn-warning',
                        callback: function(){
                            $.ajax( urlDelete + "/" + id,{
                                type : 'POST',
                                data: {
                                    related : true
                                },
                            })
                                .done( function( data ) {
                                    location.reload();
                                })
                                .fail( function(){
                                    alert( 'Could add MAC address. API / AJAX / network error' );
                                    throw new Error("Error running ajax query for " + urlDelete + "/" + id );
                                })
                        }
                    },
                    confirm: {
                        label: "Delete",
                        className: 'btn-danger',
                        callback: function(){
                            $.ajax( urlDelete + "/" + id,{
                                type : 'POST'
                            })
                                .done( function( data ) {
                                    location.reload();
                                })
                                .fail( function(){
                                    alert( 'Could add MAC address. API / AJAX / network error' );
                                    throw new Error("Error running ajax query for " + urlDelete + "/" + id );
                                })
                        }
                    }
                }
            });
        }
    }

    /**
     * initialise the datatable table
     */
    function loadDataTable( tableId ){
        table = $( '#table-' + tableId ).DataTable( {
            "autoWidth": false,
            "iDisplayLength": 100
        });
    }
</script>