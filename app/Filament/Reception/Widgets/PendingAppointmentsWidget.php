<?php

namespace App\Filament\Reception\Widgets;

use App\Models\Appointment;
use Filament\Tables;
use Filament\Tables\Table;
use Filament\Widgets\TableWidget as BaseWidget;
use Illuminate\Database\Eloquent\Builder;

class PendingAppointmentsWidget extends BaseWidget
{
    protected static ?int $sort = 1;
    
    protected int | string | array $columnSpan = 'full';

    public function table(Table $table): Table
    {
        return $table
            ->query(
                // Only pull appointments that need the receptionist's attention
                Appointment::query()
                    ->where('status', 'pending')
                    ->latest('created_at')
            )
            ->heading('Action Required: Pending Requests')
            ->description('Incoming appointment requests from the website patient portal.')
            ->columns([
                Tables\Columns\TextColumn::make('created_at')
                    ->label('Requested On')
                    ->dateTime('M d, h:i A')
                    ->description('Time elapsed')
                    ->color('gray'),

                Tables\Columns\TextColumn::make('patient_name')
                    ->label('Patient Details')
                    ->weight('bold')
                    ->description(fn (Appointment $record): string => $record->patient_phone),

                Tables\Columns\TextColumn::make('department.name')
                    ->label('Department Requested')
                    ->badge()
                    ->color('info'),

                Tables\Columns\TextColumn::make('doctor.name')
                    ->label('Preferred Doctor')
                    ->default('Any Available'),

                Tables\Columns\TextColumn::make('appointment_date')
                    ->label('Requested Schedule')
                    ->date('l, M d')
                    ->weight('bold')
                    ->description(fn (Appointment $record): string => \Carbon\Carbon::parse($record->appointment_time)->format('h:i A')),
            ])
            ->actions([
                Tables\Actions\Action::make('approve')
                    ->label('Approve')
                    ->icon('heroicon-m-check-badge')
                    ->color('success')
                    ->requiresConfirmation()
                    ->modalHeading('Approve Appointment')
                    ->modalDescription('Are you sure you want to approve this appointment? The patient will see this in their portal.')
                    ->modalSubmitActionLabel('Yes, Approve')
                    ->action(fn (Appointment $record) => $record->update(['status' => 'approved'])),

                Tables\Actions\Action::make('cancel')
                    ->label('Decline')
                    ->icon('heroicon-m-x-circle')
                    ->color('danger')
                    ->requiresConfirmation()
                    ->modalHeading('Decline Request')
                    ->modalDescription('This will mark the request as cancelled. Only do this if the time slot is truly unavailable in the main HMS.')
                    ->action(fn (Appointment $record) => $record->update(['status' => 'cancelled'])),
            ])
            ->emptyStateHeading('All caught up!')
            ->emptyStateDescription('There are no pending appointment requests at this time.')
            ->emptyStateIcon('heroicon-o-face-smile')
            ->paginated([5, 10, 25]);
    }
}
