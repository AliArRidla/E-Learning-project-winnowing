<!-- Modal add guru -->
<div wire:ignore.self class="modal fade" id="mdlAddGuru" data-backdrop="static" data-keyboard="false" tabindex="-1" data-focus="true"
    data-show="true" aria-labelledby="staticBackdropLabel" aria-hidden="true">
    <div class="modal-dialog modal-lg modal-dialog-centered modal-dialog-scrollable">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title" id="staticBackdropLabel">Tambah Guru</h5>
                <button type="button" class="close" data-dismiss="modal" aria-label="Close" wire:click="reload()">
                    <span aria-hidden="true">&times;</span>
                </button>
            </div>
            <form wire:submit.prevent="submit">
                <div class="modal-body">
                    <div class="form-row">
                        <div class="form-group col-md-6">
                            <label for="name">Name</label>
                            <input wire:model.debounce.800ms="name" type="text" class="form-control" id="name" name="name">
                            @error('name')
                        <span id="error-msg">{{ $message }}</span>
                        @enderror
                        </div>
                        <div class="form-group col-md-6">
                            <label for="role">Role</label>
                            <input type="text" class="form-control" id="role" name="role" value="Guru" disabled>
                        </div>
                    </div>
                    <div class="form-row">
                        <div class="form-group col-md-6">
                            <label for="email">Email</label>
                            <input wire:model.debounce.800ms="email" type="email" class="form-control" id="email" name="email">
                            @error('email')
                        <span id="error-msg">{{ $message }}</span>
                        @enderror
                        </div>
                        <div class="form-group col-md-6">
                            <label for="password">Password</label>
                            <input wire:model.debounce.800ms="password" type="password" class="form-control" id="password" name="password">
                            @error('password')
                        <span id="error-msg">{{ $message }}</span>
                        @enderror
                        </div>
                    </div>
                </div>
                <div class="modal-footer">
                    <button type="button" class="btn btn-secondary" data-dismiss="modal" wire:click="reload()">Close</button>
                    <button type="button" class="btn btn-primary" wire:click="addGuru()">Daftarkan</button>
                </div>
            </form>
        </div>
    </div>
</div>

<!-- Modal edit guru-->
{{-- <div class="modal fade" id="mdlEditGuru" data-backdrop="static" data-keyboard="false" tabindex="-1" data-focus="true"
    data-show="true" aria-labelledby="staticBackdropLabel" aria-hidden="true">
    <div class="modal-dialog modal-lg modal-dialog-centered modal-dialog-scrollable">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title" id="staticBackdropLabel">Edit Guru</h5>
                <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                    <span aria-hidden="true">&times;</span>
                </button>
            </div>
            <form method="post" action="#">
                @csrf
                <div class="modal-body"> --}}
                    {{-- @foreach ($guru as $g) --}}
                    {{-- <div class="form-row">
                        <div class="form-group col-md-6">
                            <label for="name">Name</label>
                            <input type="text" class="form-control" id="name" name="name">
                        </div>
                        <div class="form-group col-md-6">
                            <label for="role">Role</label>
                            <input type="text" class="form-control" id="role" name="role" value="Guru" disabled>
                        </div>
                    </div>
                    <div class="form-row">
                        <div class="form-group col-md-6">
                            <label for="email">Email</label>
                            <input type="email" class="form-control" id="email" name="email">
                        </div> --}}
                        {{-- <div class="form-group col-md-6">
                            <label for="password">Password</label>
                            <input type="password" class="form-control" id="password" name="password">
                        </div> --}}
                    {{-- </div>
                </div> --}}
                {{-- @endforeach --}}
                {{-- <div class="modal-footer">
                    <button type="button" class="btn btn-secondary" data-dismiss="modal">Close</button>
                    <button type="submit" class="btn btn-primary">Edit</button> --}}
                    {{-- <button type="button" class="btn btn-primary">Understood</button> --}}
                {{-- </div>
            </form>
        </div>
    </div>
</div> --}}
