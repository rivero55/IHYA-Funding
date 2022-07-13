@php
use Carbon\Carbon;
Carbon::setLocale('id');
@endphp
<label class="col-sm-12 col-form-label">Nama: <span class="card-text font-weight-bold">{{$profile->ktp_name}}</span></label>
<label class="col-sm-12 col-form-label">No KTP: <span class="card-text font-weight-bold">{{$profile->ktp_number}}</span></label>
<label for="DataNIK" class="col-sm-12 col-form-label">Pekerjaan: <span class="card-text font-weight-bold">{{$profile->job}}</span></label>
<label for="DataNIK" class="col-sm-12 col-form-label">Detail Pekerjaan: <span class="card-text font-weight-bold">{{$profile->job_detail}}</span></label>
<label for="DataNIK" class="col-sm-12 col-form-label">Social Media: <span class="card-text font-weight-bold">{{$profile->social_media}}</span></label>
<label for="DataNIK" class="col-sm-12 col-form-label">Social link: <a class="card-text font-weight-bold" href="{{$profile->social_link}}">{{$profile->social_link}}</a></label>

<hr>
<h5> Proyek Batch </h5>
<label for="DataNIK" class="col-sm-12 col-form-label">Batch ke: <span class="card-text font-weight-bold">{{$proyek_batch ->batch_no}}</span></label>
<label for="DataNIK" class="col-sm-12 col-form-label">Minimal Donasi: <span class="card-text font-weight-bold">Rp. {{ number_format($proyek_batch->minimum_fund,0,",",".") }}</span></label>
<label for="DataNIK" class="col-sm-12 col-form-label">Maksimal Donasi: <span class="card-text font-weight-bold">{{ empty($proyek_batch->maximum_fund) ? '-':'Rp. '. number_format($proyek_batch->maximum_fund,0,",",".")}}</span></label>
<label for="DataNIK" class="col-sm-12 col-form-label">Target Donasi: <span class="card-text font-weight-bold">Rp. {{ number_format($proyek_batch->target_nominal,0,",",".") }}</span></label>
<label for="DataNIK" class="col-sm-12 col-form-label">Tanggal Mulai : <span class="card-text font-weight-bold">{{ Carbon::parse($proyek_batch->start_date)->isoFormat('dddd, D MMMM Y') }}</span></label>
<label for="DataNIK" class="col-sm-12 col-form-label">Target Berakhir: <span class="card-text font-weight-bold">{{ Carbon::parse($proyek_batch->end_date)->isoFormat('dddd, D MMMM Y') }}</span></label>
<label for="DataNIK" class="col-sm-12 col-form-label">Status Proyek: <span class="card-text font-weight-bold">{{$proyek_batch->status}}</span></label>
<label for="DataNIK" class="col-sm-12 col-form-label">Verification Status: <span class="card-text font-weight-bold">{{$proyek_batch->verification_status}}</span></label>


