<!-- Модалка сертификата -->
<div class="modal fade" id="certificateModal" tabindex="-1" aria-labelledby="certificateModalLabel" aria-hidden="true">
    <div class="modal-dialog modal-dialog-centered modal-dialog-scrollable">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title" id="certificateModalLabel">Поздравляем!</h5>
                <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Закрыть"></button>
            </div>
            <div class="modal-body text-center">
                <img class="avatar avatar-xl avatar-4x3 mb-4" src="{{asset('assets/svg/illustrations/oc-growing.svg')}}" alt="Image Description" data-hs-theme-appearance="default" style="min-height: 6rem;">
                <p>Вы успешно завершили курс <strong>{{ $course->topic }}</strong> и получили сертификат!</p>

            </div>
            <div class="modal-footer justify-content-center">
                <a href="" class="btn btn-primary">Скачать сертификат</a>
                <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Закрыть</button>
            </div>
        </div>
    </div>
</div>
