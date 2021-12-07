<span class="rz-overlay"></span>
  <div class="rz-modal rz-modal-ready" data-id="modal_certificate" data-signup="pass">
    <a href="#" class="rz-close">
      <i class="fas fa-times"></i>
    </a>
    <div class="rz-modal-heading rz--border rz-modal-title-bg">
      <h4 class="">Tilføj nyt certifikat</h4>
    </div>
    <div class="rz-modal-content">
      <div class="rz-modal-append">
        <div class="rz-modal-container">
        <!-- START MODAL CONTENT -->
          <form>
            <section class="rz-submission-step rz-active" data-id="fields" data-group="0">
              <input type="hidden" name="certificate" value="certificate" />
              <div class="rz-grid">

              <div class="rz-form-group rz-field rz-col-12 rz-relative rz-field-ready" data-type="text" data-storage="request" data-disabled="no" data-heading="Kursusnavn*" data-id="course-name">
                <input type="text" name="rz_course-name" value="" class="" placeholder=" "/>
                <label class="">
                Kursusnavn*
                <i class="rz-required"></i>
                </label>
              </div>

              <div class="rz-form-group rz-field rz-col-12 rz-relative rz-field-ready" data-type="text" data-storage="request" data-disabled="no" data-heading="Kursets afslutningstid*" data-id="course-year">
                <input type="number" min="1900" max="<?php echo date("Y"); ?>" name="rz_course-year" value="" class="" placeholder=" "/>
                <label class="">
                Kursets afslutningstid*
                <i class="rz-required"></i>
                </label>
              </div>
            </section>
            <!-- <input type="hidden" name = "location" value = "/my-account/edit-account/"> -->
          </form>
         
        <!-- END MODAl CONTENT -->
        </div>
        <div class="rz-modal-footer rz--top-border btn-group">
          <a href="#" class="rz-close rz-modal-button rz-mr-2 btn btn-line-dark"><span>Annuler</span></a>

          <input type="submit" value="Gem" class="rz-modal-button btn btn-accent rz-close" data-id="add_certificate"/>
        </div>
      </div>
    </div>
  </div>