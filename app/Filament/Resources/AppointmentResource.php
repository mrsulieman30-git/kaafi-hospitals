<?php

namespace App\Filament\Resources;

use App\Filament\Resources\AppointmentResource\Pages;
use App\Models\Appointment;
use Filament\Forms;
use Filament\Forms\Form;
use Filament\Resources\Resource;
use Filament\Tables;
use Filament\Tables\Table;
use Illuminate\Database\Eloquent\Builder;

class AppointmentResource extends Resource
{
    protected static ?string $model = Appointment::class;

    protected static ?string $navigationIcon = 'heroicon-o-calendar-days';

    public static function getNavigationGroup(): ?string
    {
        return 'Reception Desk';
    }

    public static function form(Form $form): Form
    {
        return $form
            ->schema([
                Forms\Components\Grid::make(3)
                    ->schema([
                        // Main Appointment Column
                        Forms\Components\Section::make('Schedule Consultation')
                            ->schema([
                                Forms\Components\Select::make('department_id')
                                    ->relationship('department', 'name')
                                    ->required()
                                    ->preload()
                                    ->live(), // Auto-updates the doctor list based on department
                                    
                                Forms\Components\Select::make('doctor_id')
                                    ->relationship('doctor', 'name', fn (Builder $query, Forms\Get $get) => 
                                        $get('department_id') ? $query->where('department_id', $get('department_id')) : $query
                                    )
                                    ->required()
                                    ->searchable()
                                    ->preload()
                                    ->live(),
                                    
                                Forms\Components\DatePicker::make('appointment_date')
                                    ->required()
                                    ->native(false)
                                    ->minDate(today())
                                    ->disabledDates(function (Forms\Get $get) {
                                        $doctorId = $get('doctor_id');
                                        if (!$doctorId) return [];
                                        $doctor = \App\Models\Doctor::find($doctorId);
                                        return $doctor ? $doctor->getDisabledDatesForNextDays(90) : [];
                                    })
                                    ->live(),
                                    
                                Forms\Components\Select::make('appointment_time')
                                    ->required()
                                    ->options(function (Forms\Get $get) {
                                        $doctorId = $get('doctor_id');
                                        $date = $get('appointment_date');
                                        
                                        if (!$doctorId || !$date) {
                                            return [];
                                        }
                                        
                                        $doctor = \App\Models\Doctor::find($doctorId);
                                        if (!$doctor) return [];
                                        
                                        $slots = $doctor->getAvailableTimeSlots($date);
                                        $formatted = [];
                                        foreach ($slots as $time) {
                                            $formatted[$time] = \Carbon\Carbon::parse($time)->format('h:i A');
                                        }
                                        return $formatted;
                                    })
                                    ->searchable(),
                                    
                                Forms\Components\Textarea::make('notes')
                                    ->columnSpanFull()
                                    ->placeholder('Patient symptoms or reception notes...'),
                            ])->columns(2)->columnSpan(2),

                        // Sidebar: Patient Details & Status
                        Forms\Components\Group::make()
                            ->schema([
                                Forms\Components\Section::make('Patient Identity')
                                    ->schema([
                                        Forms\Components\Select::make('user_id')
                                            ->label('Registered Patient Account')
                                            ->relationship('user', 'name', fn (Builder $query) => $query->role('Patient'))
                                            ->searchable()
                                            ->preload()
                                            ->helperText('Link to an existing patient portal account.'),
                                            
                                        Forms\Components\TextInput::make('patient_name')
                                            ->label('Walk-in Name')
                                            ->required()
                                            ->maxLength(255),
                                            
                                        Forms\Components\TextInput::make('patient_phone')
                                            ->tel()
                                            ->required()
                                            ->prefix('+252'),
                                    ]),
                                    
                                Forms\Components\Section::make('Status')
                                    ->schema([
                                        Forms\Components\ToggleButtons::make('status')
                                            ->options([
                                                'pending' => 'Pending',
                                                'approved' => 'Approved',
                                                'completed' => 'Completed',
                                                'cancelled' => 'Cancelled',
                                            ])
                                            ->colors([
                                                'pending' => 'warning',
                                                'approved' => 'success',
                                                'completed' => 'info',
                                                'cancelled' => 'danger',
                                            ])
                                            ->inline()
                                            ->required()
                                            ->default('pending'),
                                    ]),
                            ])->columnSpan(1),
                    ]),
            ]);
    }

    public static function table(Table $table): Table
    {
        return $table
            ->columns([
                Tables\Columns\TextColumn::make('patient_name')
                    ->label('Patient')
                    ->searchable()
                    ->weight('bold')
                    ->description(fn (Appointment $record) => $record->patient_phone),
                    
                Tables\Columns\TextColumn::make('doctor.name')
                    ->label('Doctor')
                    ->badge()
                    ->color('gray'),
                    
                Tables\Columns\TextColumn::make('appointment_date')
                    ->label('Date & Time')
                    ->date('D, M d, Y')
                    ->description(fn (Appointment $record) => \Carbon\Carbon::parse($record->appointment_time)->format('h:i A'))
                    ->sortable(),
                    
                Tables\Columns\TextColumn::make('status')
                    ->badge()
                    ->colors([
                        'warning' => 'pending',
                        'success' => fn ($state) => in_array($state, ['approved', 'completed']),
                        'danger' => 'cancelled',
                    ]),
            ])
            ->defaultSort('appointment_date', 'desc')
            ->filters([
                Tables\Filters\SelectFilter::make('status')
                    ->options([
                        'pending' => 'Pending',
                        'approved' => 'Approved',
                        'completed' => 'Completed',
                        'cancelled' => 'Cancelled',
                    ]),
            ])
            ->actions([
                Tables\Actions\ViewAction::make()->slideOver(), // Added View
                Tables\Actions\EditAction::make(),
            ]);
    }

    public static function getRelations(): array { return []; }

    public static function getPages(): array
    {
        return [
            'index' => Pages\ListAppointments::route('/'),
            'create' => Pages\CreateAppointment::route('/create'),
            'edit' => Pages\EditAppointment::route('/{record}/edit'),
        ];
    }
}