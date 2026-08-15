@if($errors->any())
    <div
        id="resumen-errores"
        class="rounded-xl border border-red-200 bg-red-50 p-4 text-red-800"
        role="alert"
        tabindex="-1"
    >
        <div class="flex items-start gap-3">
            @svg('heroicon-o-exclamation-circle', 'mt-0.5 h-5 w-5 shrink-0')
            <div>
                <h2 class="text-sm font-bold">Revisa los campos indicados</h2>
                <p class="mt-1 text-sm">No pudimos guardar la información por los siguientes motivos:</p>
                <ul class="mt-2 list-disc space-y-1 pl-5 text-sm">
                    @foreach($errors->all() as $error)
                        <li>{{ $error }}</li>
                    @endforeach
                </ul>
            </div>
        </div>
    </div>
@endif
