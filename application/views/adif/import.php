
<div class="container adif">

	<h2><?php echo $page_title; ?></h2>
    <div class="card">
    <div class="card-header">
    <ul class="nav nav-tabs card-header-tabs pull-right" role="tablist">
        <li class="nav-item">
            <a class="nav-link active" id="import-tab" data-toggle="tab" href="#import" role="tab" aria-controls="import" aria-selected="true">ADIF Import</a>
        </li>
		<?php if(($this->config->item('use_auth') && ($this->session->userdata('user_type') >= 3)) || $this->config->item('use_auth') === FALSE || ($this->config->item('show_time'))) { ?>
            <li class="nav-item">
                <a class="nav-link" id="export-tab" data-toggle="tab" href="#export" role="tab" aria-controls="export" aria-selected="false">ADIF Export</a>
            </li>
            <li class="nav-item">
                <a class="nav-link" id="lotw-tab" data-toggle="tab" href="#lotw" role="tab" aria-controls="lotw" aria-selected="false">Logbook Of The World</a>
            </li>
            <li class="nav-item">
                <a class="nav-link" id="qrz-tab" data-toggle="tab" href="#qrz" role="tab" aria-controls="qrz" aria-selected="false">QRZ Logbook</a>
            </li>
		<?php } ?>
    </ul>
    </div>

    <div class="card-body">
        <div class="tab-content">
            <div class="tab-pane  active" id="import" role="tabpanel" aria-labelledby="home-tab">

                <?php if(isset($error)) { ?>
                    <div class="alert alert-danger" role="alert">
                      <?php echo $error; ?>
                    </div>
                <?php } ?>

                <p><span class="badge badge-warning"> Ważne </span> Pliki dziennika muszą mieć typ pliku .adi</p>
                <p><span class="badge badge-warning"> Ostrzeżenie </span> Maksymalny rozmiar przesyłanych plików:  <?php echo $max_upload; ?>B.</p>

                <div class="alert alert-warning" role="alert" style="color: #ffffff; background-color: #ff0000; border-color: #ff0000; padding: 0.7rem 0.7rem;">
			        <span class="badge badge-info" style="font-size: 90%; margin-right: 10px; color: #212529; background-color: #ffc107;">Bardzo ważne</span><b> Łączności zapisane w pliku .adi muszą dotyczyć tylko znaku klubowego SP9KRJ. Proces importu danych jest nieodwracalny.</b>
                </div>

                <form class="form" action="<?php echo site_url('adif/import'); ?>" method="post" enctype="multipart/form-data">
                    <select name="station_profile" class="custom-select mb-2 mr-sm-2" style="width: 20%;">
                    <option value="0">Wybierz znak stacji</option>
                    <?php foreach ($station_profile->result() as $station) { ?>
                    <option value="<?php echo $station->station_id; ?>"><?php echo $station->station_callsign; ?></option>
                    <?php } ?>
                    </select>
                  <label class="sr-only" for="inlineFormInputName2">ADIF file</label>
                  <input class="file-input mb-2 mr-sm-2" type="file" name="userfile" size="20" />

                  <?php if(($this->config->item('use_auth') && ($this->session->userdata('user_type') >= 3)) || $this->config->item('use_auth') === FALSE || ($this->config->item('show_time'))) { ?>
                   <div class="form-group row">
                        <div class="col-md-10">
                            <div class="form-check-inline">
                                <input class="form-check-input" type="checkbox" name="skipDuplicate" value="1" id="skipDuplicate">
                                <label class="form-check-label" for="skipDuplicate">Pomiń sprawdzanie duplikatów łączności</label>
                            </div>
                        </div>
                    </div>

                    <div class="form-group row">
                        <div class="col-md-10">
                            <div class="form-check-inline">
                                <input class="form-check-input" type="checkbox" name="markLotw" value="1" id="markLotwImport">
                                <label class="form-check-label" for="markLotwImport">Oznacz importowane QSO jako przesłane do LoTW</label>
                            </div>
                            <div class="small form-text text-muted">Wybierz, jeśli importowany ADIF nie zawiera tych informacji.</div>
                        </div>
                    </div>

                    <div class="form-group row">
                        <div class="col-md-10">
                            <div class="form-check-inline">
                                <input class="form-check-input" type="checkbox" name="markQrz" value="1" id="markQrzImport">
                                <label class="form-check-label" for="markQrzImport">Oznacz importowane QSO jako przesłane do dziennika QRZ</label>
                            </div>
                            <div class="small form-text text-muted">Wybierz, jeśli importowany ADIF nie zawiera tych informacji.</div>
                        </div>
                    </div>
                    <?php } ?>

                    <div class="form-group row">
                        <div class="col-md-10">
                            <div class="form-check-inline">
                                <input class="form-check-input" type="checkbox" name="dxccAdif" value="1" id="dxccAdif">
                                <label class="form-check-label" for="dxccAdif">Użyj informacji DXCC z ADIF</label>
                            </div>
                            <div class="small form-text text-muted">Jeśli nie jest zaznaczone, Cloudlog spróbuje automatycznie określić informacje DXCC.</div>
                        </div>
                    </div>
					<div class="form-group row">
						<div class="col-md-10">
							<div class="form-check-inline">
								<input class="form-check-input" type="checkbox" name="operatorName" value="1" id="operatorName">
								<label class="form-check-label" for="operatorName">Zawsze używaj znaku logowania jako nazwy operatora podczas importu</label>
							</div>
						</div>
					</div>

                  <button type="submit" class="btn btn-primary" value="Upload">Wyślij dziennik łączności</button>
                </form>
                </div>

        <div class="tab-pane fade" id="export" role="tabpanel" aria-labelledby="home-tab">

		  <form class="form" action="<?php echo site_url('adif/export_custom'); ?>" method="post" enctype="multipart/form-data">
                <h5 class="card-title">Take your logbook file anywhere!</h5>
                <p class="card-text">Exporting ADIFs allows you to import contacts into third party applications like LoTW, Awards or just for keeping a backup.</p>
					  <select name="station_profile" class="custom-select mb-2 mr-sm-2" style="width: 20%;">
						  <option value="0">Select Station Profile</option>
						  <?php foreach ($station_profile->result() as $station) { ?>
							  <option value="<?php echo $station->station_id; ?>">Callsign: <?php echo $station->station_callsign; ?> (<?php echo $station->station_profile_name; ?>)</option>
						  <?php } ?>
					  </select>
                      <p class="card-text">From date:</p>
                      <div class="row">
                          <div class="input-group date col-md-3" id="datetimepicker1" data-target-input="nearest">
                              <input name="from" type="text" placeholder="DD/MM/YYYY" class="form-control datetimepicker-input" data-target="#datetimepicker1"/>
                              <div class="input-group-append"  data-target="#datetimepicker1" data-toggle="datetimepicker">
                                  <div class="input-group-text"><i class="fa fa-calendar"></i></div>
                              </div>
                          </div>
                      </div>

                      <p class="card-text">To date:</p>
                      <div class="row">
                          <div class="input-group date col-md-3" id="datetimepicker2" data-target-input="nearest">
                              <input name="to" "totype="text" placeholder="DD/MM/YYYY" class="form-control datetimepicker-input" data-target="#datetimepicker2"/>
                              <div class="input-group-append" data-target="#datetimepicker2" data-toggle="datetimepicker">
                                  <div class="input-group-text"><i class="fa fa-calendar"></i></div>
                              </div>
                          </div>
                      </div>
                        <br>
                      <div class="form-group row">
                          <div class="col-md-10">
                              <div class="form-check-inline">
                                  <input class="form-check-input" type="checkbox" name="markLotw" value="1" id="markLotwExport">
                                  <label class="form-check-label" for="markLotwExport">Mark exported QSOs as uploaded to LoTW</label>
                              </div>
                          </div>
                      </div>
                      <div class="form-group row">
                          <div class="col-md-10">
                              <div class="form-check-inline">
                                  <input class="form-check-input" type="checkbox" name="exportLotw" value="1" id="exportLotw">
                                  <label class="form-check-label" for="exportLotw">Export QSOs not uploaded to LoTW</label>
                              </div>
                          </div>
                      </div>

                <button type="submit" class="btn-sm btn-primary" value="Export">Export QSOs</button>
		  </form>

                <br><br>

                <h5>Export Satellite-Only QSOs</h5>
                <p><a href="<?php echo site_url('adif/exportsat'); ?>" title="Export All Satellite Contacts" target="_blank" class="btn-sm btn-primary">Export All Satellite QSOs</a></p>

                <p><a href="<?php echo site_url('adif/exportsatlotw'); ?>" title="Export All Satellite QSOS Confirmed on LoTW" target="_blank" class="btn-sm btn-primary">Export All Satellite QSOs Confirmed on LoTW</a></p>
                </div>


        <div class="tab-pane fade" id="lotw" role="tabpanel" aria-labelledby="home-tab">
            <form class="form" action="<?php echo site_url('adif/mark_lotw'); ?>" method="post" enctype="multipart/form-data">
				<select name="station_profile" class="custom-select mb-2 mr-sm-2" style="width: 20%;">
					<option value="0">Select Station Profile</option>
					<?php foreach ($station_profile->result() as $station) { ?>
						<option value="<?php echo $station->station_id; ?>">Callsign: <?php echo $station->station_callsign; ?> (<?php echo $station->station_profile_name; ?>)</option>
					<?php } ?>
				</select>
				<p><span class="badge badge-warning">Warning</span> If a date range is not selected then all QSOs will be marked!</p>
                <p class="card-text">From date:</p>
                <div class="row">
                    <div class="input-group date col-md-3" id="datetimepicker3" data-target-input="nearest">
                        <input name="from" type="text" placeholder="DD/MM/YYYY" class="form-control datetimepicker-input" data-target="#datetimepicker1"/>
                        <div class="input-group-append"  data-target="#datetimepicker3" data-toggle="datetimepicker">
                            <div class="input-group-text"><i class="fa fa-calendar"></i></div>
                        </div>
                    </div>
                </div>
                <p class="card-text">To date:</p>
                <div class="row">
                    <div class="input-group date col-md-3" id="datetimepicker4" data-target-input="nearest">
                        <input name="to" "totype="text" placeholder="DD/MM/YYYY" class="form-control datetimepicker-input" data-target="#datetimepicker2"/>
                        <div class="input-group-append" data-target="#datetimepicker4" data-toggle="datetimepicker">
                            <div class="input-group-text"><i class="fa fa-calendar"></i></div>
                        </div>
                    </div>
                </div>
                <br>
                <button type="submit" class="btn-sm btn-primary" value="Export">Mark QSOs as exported to LoTW</button>
            </form>
            </div>

        <div class="tab-pane fade" id="qrz" role="tabpanel" aria-labelledby="home-tab">


                    <form class="form" action="<?php echo site_url('adif/mark_qrz'); ?>" method="post" enctype="multipart/form-data">
						<select name="station_profile" class="custom-select mb-2 mr-sm-2" style="width: 20%;">
							<option value="0">Select Station Profile</option>
							<?php foreach ($station_profile->result() as $station) { ?>
								<option value="<?php echo $station->station_id; ?>">Callsign: <?php echo $station->station_callsign; ?> (<?php echo $station->station_profile_name; ?>)</option>
							<?php } ?>
						</select>
						<p><span class="badge badge-warning">Warning</span> If a date range is not selected then all QSOs will be marked!</p>
                        <p class="card-text">From date:</p>
                        <div class="row">
                            <div class="input-group date col-md-3" id="datetimepicker5" data-target-input="nearest">
                                <input name="from" type="text" placeholder="DD/MM/YYYY" class="form-control datetimepicker-input" data-target="#datetimepicker1"/>
                                <div class="input-group-append"  data-target="#datetimepicker5" data-toggle="datetimepicker">
                                    <div class="input-group-text"><i class="fa fa-calendar"></i></div>
                                </div>
                            </div>
                        </div>
                        <p class="card-text">To date:</p>
                        <div class="row">
                            <div class="input-group date col-md-3" id="datetimepicker6" data-target-input="nearest">
                                <input name="to" "totype="text" placeholder="DD/MM/YYYY" class="form-control datetimepicker-input" data-target="#datetimepicker2"/>
                                <div class="input-group-append" data-target="#datetimepicker6" data-toggle="datetimepicker">
                                    <div class="input-group-text"><i class="fa fa-calendar"></i></div>
                                </div>
                            </div>
                        </div>
                        <br>
                        <button type="submit" class="btn-sm btn-primary" value="Export">Mark QSOs as exported to QRZ Logbook</button>
                    </form>
        </div>
    </div>
    </div>
    </div>
