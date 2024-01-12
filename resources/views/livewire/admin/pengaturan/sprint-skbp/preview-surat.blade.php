{{-- The whole world belongs to you. --}}


<div class="row justify-content-between">
    <div class="col-12">
        <x-admin.components.card.card title='SURAT PERINTAH TUGAS ' titleSpan='Bebas Pustaka Perpustakaan Pusat'>
            <object data="{{asset("storage/dokumen/" . $sprint)}}"
                type="application/pdf" width="100%" height="500px">
                <p>Unable to display PDF file. <a
                        href="/uploads/media/default/0001/01/540cb75550adf33f281f29132dddd14fded85bfc.pdf">Download</a>
                    instead.</p>
            </object> </x-admin.components.card.card>
    </div>
</div>
