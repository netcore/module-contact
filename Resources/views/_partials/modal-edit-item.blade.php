<div id="edit-item" class="modal fade" role="dialog">
    <div class="modal-dialog">

        <!-- Modal content-->
        <div class="modal-content">
            <div class="modal-header">
                <button type="button" class="close" data-dismiss="modal">&times;</button>
                <h4 class="modal-title">Modal Header</h4>
            </div>
            <div class="modal-body">
                {{ Form::open(['route' => 'admin::contact.item.update', 'method' => 'put', 'class' => 'js-edit-field']) }}
                <div class="alert alert-danger hidden"></div>
                <div class="form-group">
                    {{ Form::hidden('item_id', null) }}
                    {{ Form::hidden('type', null) }}
                    <div class="js-other-fields hidden">
                        {{ Form::label('field', 'Type', ['class' => 'control-label']) }}
                        {{ Form::text('value', null, ['class' => 'form-control']) }}
                    </div>
                    <div class="js-workday-fields hidden">
                        <table class="table table-bordered">
                            <thead>
                                <tr>
                                    <th>Days</th>
                                    <th>Work hours</th>
                                </tr>
                            </thead>
                            <tbody>

                            </tbody>
                        </table>
                    </div>
                    <div class="js-contact-form hidden">
                        <select name="value" class="form-control">

                        </select>
                    </div>

                </div>
                <div class="form-group">
                    {{ Form::submit('Save', ['class' => 'btn btn-success']) }}
                </div>
                {{ Form::close() }}

                {{ Form::open(['url' => '#', 'method' => 'post', 'class' => 'js-edit-workdays hidden']) }}
                <div class="form-group">
                    <div class="col-md-4"></div>
                    {{ Form::label('field', 'Type', ['class' => 'control-label']) }}
                    {{ Form::text('value', null, ['class' => 'form-control']) }}
                </div>
                <div class="form-group">
                    {{ Form::submit('Save', ['class' => 'btn btn-success']) }}
                </div>
                {{ Form::close() }}
            </div>
        </div>

    </div>
</div>