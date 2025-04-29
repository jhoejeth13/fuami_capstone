@extends('layouts.app')

@section('content')
<div class="container">
    <div class="row justify-content-center">
        <div class="col-md-10">
            <div class="card">
                <div class="card-header bg-primary text-white">
                    <h4 class="mb-0"><i class="fa fa-chart-bar mr-2"></i> Alumni Reports Dashboard</h4>
                </div>
                <div class="card-body">
                    <div class="row">
                        <div class="col-md-6 mb-4">
                            <div class="card h-100 shadow-sm">
                                <div class="card-body">
                                    <h5 class="card-title"><i class="fa fa-user-tie text-primary mr-2"></i>Profession Reports</h5>
                                    <p class="card-text">View distribution of alumni by their professional occupations and career paths.</p>
                                    <div class="mt-3">
                                        <a href="{{ route('reports.profession', ['graduate_type' => 'SHS']) }}" class="btn btn-outline-primary mr-2">
                                            <i class="fa fa-user-graduate mr-1"></i> SHS Alumni
                                        </a>
                                        <a href="{{ route('reports.profession', ['graduate_type' => 'JHS']) }}" class="btn btn-outline-primary">
                                            <i class="fa fa-school mr-1"></i> JHS Alumni
                                        </a>
                                    </div>
                                </div>
                            </div>
                        </div>
                        
                        <div class="col-md-6 mb-4">
                            <div class="card h-100 shadow-sm">
                                <div class="card-body">
                                    <h5 class="card-title"><i class="fa fa-building text-primary mr-2"></i>Organization Type Reports</h5>
                                    <p class="card-text">View distribution of alumni by organization types they work for.</p>
                                    <div class="mt-3">
                                        <a href="#" class="btn btn-outline-secondary mr-2 disabled">
                                            <i class="fa fa-user-graduate mr-1"></i> Coming Soon
                                        </a>
                                    </div>
                                </div>
                            </div>
                        </div>
                        
                        <div class="col-md-6 mb-4">
                            <div class="card h-100 shadow-sm">
                                <div class="card-body">
                                    <h5 class="card-title"><i class="fa fa-map-marker-alt text-primary mr-2"></i>Geographic Distribution</h5>
                                    <p class="card-text">View distribution of alumni by their geographic location.</p>
                                    <div class="mt-3">
                                        <a href="#" class="btn btn-outline-secondary mr-2 disabled">
                                            <i class="fa fa-user-graduate mr-1"></i> Coming Soon
                                        </a>
                                    </div>
                                </div>
                            </div>
                        </div>
                        
                        <div class="col-md-6 mb-4">
                            <div class="card h-100 shadow-sm">
                                <div class="card-body">
                                    <h5 class="card-title"><i class="fa fa-calendar-alt text-primary mr-2"></i>Year-based Reports</h5>
                                    <p class="card-text">View alumni statistics and trends based on graduation year.</p>
                                    <div class="mt-3">
                                        <a href="#" class="btn btn-outline-secondary mr-2 disabled">
                                            <i class="fa fa-user-graduate mr-1"></i> Coming Soon
                                        </a>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>
@endsection 