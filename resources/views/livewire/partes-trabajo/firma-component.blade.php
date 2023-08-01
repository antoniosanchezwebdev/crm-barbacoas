<div class="modal-dialog">
    <script src="https://cdnjs.cloudflare.com/ajax/libs/signature_pad/1.3.4/signature_pad.js"
        integrity="sha512-j36pYCzm3upwGd6JGq6xpdthtxcUtSf5yQJSsgnqjAsXtFT84WH8NQy9vqkv4qTV9hK782TwuHUTSwo2hRF+/A=="
        crossorigin="anonymous" referrerpolicy="no-referrer"></script>
    <div class="modal-content">
        <div class="modal-header">
            <h5 class="modal-title" id="signatureModalLabel-{{ $parte_id }}">Firma aquí</h5>
            <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
        </div>
        <div class="modal-body">
            <div class="border">
            <canvas id="signature-pad" class="signature-pad" width=400 height=200></canvas>
            </div>
        </div>
        <div class="modal-footer">
            <button type="button" class="btn btn-dark" data-bs-dismiss="modal">Cerrar</button>
            <button type="button" class="btn btn-tab" id="save-png-button">Guardar</button>
            <button type="button" class="btn btn-secondary"id="clear-button">Borrar</button>
        </div>
    </div>
    <script>
        var canvas = document.querySelector('#signature-pad');
        var signaturePad = new SignaturePad(canvas);

        // Botón para borrar
        document.querySelector('#clear-button').addEventListener('click', function() {
            signaturePad.clear();
        });

        // Botón para guardar
        document.querySelector('#save-png-button').addEventListener('click', function() {
            if (signaturePad.isEmpty()) {
                alert("Por favor, proporciona una firma primero.");
            } else {
                var dataURL = signaturePad.toDataURL();
                Livewire.emit('saveSignature', dataURL); // Enviar a Livewire
            }
        });
    </script>
</div>
