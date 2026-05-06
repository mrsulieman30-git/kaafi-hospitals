<?php

namespace App\Filament\Widgets;

use App\Models\Appointment;
use Filament\Tables;
use Filament\Tables\Table;
use Filament\Widgets\TableWidget as BaseWidget;
use Illuminate\Database\Eloquent\Builder;

class TodaysAppointmentsWidget extends BaseWidget
{
    protected static ?int $sort = 2; // Places it below the stats overview
    
    protected int | string | array $columnSpan = 'full';

    public function table(Table $table): Table
    {
        return $table
            ->query(
                Appointment::query()
                    ->whereDate('appointment_date', today())
                    ->latest('appointment_time')
            )
            ->heading("Today's Pulse")
            ->description("Real-time view of today's scheduled consultations.")
            ->columns([
                Tables\Columns\TextColumn::make('appointment_time')
                    ->label('Time')
                    ->time('h:i A')
                    ->weight('bold')
                    ->color('primary')
                    ->icon('heroicon-o-clock'),
                    
                Tables\Columns\TextColumn::make('patient_name')
                    ->label('Patient')
                    ->searchable()
                    ->weight('medium'),
                    
                Tables\Columns\TextColumn::make('doctor.name')
                    ->label('Attending Doctor')
                    ->badge()
                    ->color('gray'),
                    
                Tables\Columns\TextColumn::make('department.name')
                    ->label('Department'),
                    
                Tables\Columns\TextColumn::make('status')
                    ->badge()
                    ->colors([
                        'warning' => 'pending',
                        'success' => fn ($state) => in_array($state, ['approved', 'completed']),
                        'danger' => 'cancelled',
                    ])
                    ->icons([
                        'heroicon-o-arrow-path' => 'pending',
                        'heroicon-o-check-circle' => fn ($state) => in_array($state, ['approved', 'completed']),
                        'heroicon-o-x-circle' => 'cancelled',
                    ]),
            ])
            ->actions([
                Tables\Actions\Action::make('approve')
                    ->icon('heroicon-m-check')
                    ->color('success')
                    ->action(fn (Appointment $record) => $record->update(['status' => 'approved']))
                    ->visible(fn (Appointment $record) => $record->status === 'pending'),
                    
                Tables\Actions\EditAction::make()
                    ->iconButton(),
            ])
            ->paginated(false); // Keeps it clean as a snapshot
    }
}
