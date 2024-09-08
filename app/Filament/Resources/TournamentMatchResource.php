<?php

namespace App\Filament\Resources;

use App\Filament\Resources\TournamentMatchResource\Pages;
use App\Filament\Resources\TournamentMatchResource\RelationManagers;
use App\Models\TournamentMatch;
use Filament\Forms;
use Filament\Forms\Form;
use Filament\Resources\Resource;
use Filament\Tables;
use Filament\Tables\Table;
use Illuminate\Database\Eloquent\Builder;
use Illuminate\Database\Eloquent\SoftDeletingScope;
use Illuminate\Support\Facades\DB;

class TournamentMatchResource extends Resource
{
    protected static ?string $model = TournamentMatch::class;

    protected static ?string $navigationIcon = 'heroicon-o-table-cells';

    protected static ?string $navigationGroup = 'Fat Bear Week';

    protected static ?string $navigationLabel = 'Matches';

    public static function form(Form $form): Form
    {
        return $form
            ->schema([
                Forms\Components\Select::make('tournament_id')
                    ->relationship('tournament', 'label', fn (Builder $query) => $query->orderBy('order_index'))
                    ->required(),
                Forms\Components\DatePicker::make('match_date')
                    ->required(),
                Forms\Components\TextInput::make('sequence')
                    ->required()
                    ->numeric(),
                Forms\Components\Toggle::make('is_bye')
                    ->required(),
                Forms\Components\Select::make('first_bear_id')
                    ->relationship('first_bear', 'name')
                    ->searchable()
                    ->preload(),
                Forms\Components\Select::make('second_bear_id')
                    ->relationship('second_bear', 'name')
                    ->searchable()
                    ->preload(),
                Forms\Components\Select::make('first_prior_tournament_match_id')
                    ->label('1st Prior Match')
                    ->relationship('first_prior_match')
                    ->getOptionLabelFromRecordUsing(fn (TournamentMatch $match) => "{$match->match_date->toFormattedDateString()} ({$match->sequence})")
                    ->searchable()
                    ->preload(),
                Forms\Components\Select::make('second_prior_tournament_match_id')
                    ->label('2nd Prior Match')
                    ->relationship('second_prior_match')
                    ->getOptionLabelFromRecordUsing(fn (TournamentMatch $match) => "{$match->match_date->toFormattedDateString()} ({$match->sequence})")
                    ->searchable()
                    ->preload(),
                Forms\Components\Select::make('winning_bear_id')
                    ->relationship('winner', 'name')
                    ->searchable()
                    ->preload()
                    ->columnSpanFull(),
            ]);
    }

    public static function table(Table $table): Table
    {
        return $table
            ->columns([
                Tables\Columns\TextColumn::make('tournament.label')
                    ->sortable(),
                Tables\Columns\TextColumn::make('match_date')
                    ->date()
                    ->sortable(),
                Tables\Columns\TextColumn::make('sequence')
                    ->numeric()
                    ->sortable(),
                Tables\Columns\TextColumn::make('first_bear.name')
                    ->numeric()
                    ->sortable(),
                Tables\Columns\IconColumn::make('is_bye')
                    ->boolean()
                    ->toggleable(isToggledHiddenByDefault: true),
                Tables\Columns\TextColumn::make('second_bear.name')
                    ->numeric()
                    ->sortable(),
                Tables\Columns\TextColumn::make('winner.name')
                    ->sortable(),
                Tables\Columns\TextColumn::make('first_prior_tournament_match_id')
                    ->label('1st Prior Match')
                    ->default('n/a')
                    ->numeric()
                    ->sortable()
                    ->toggleable(isToggledHiddenByDefault: true),
                Tables\Columns\TextColumn::make('second_prior_tournament_match_id')
                    ->label('2nd Prior Match')
                    ->default('n/a')
                    ->numeric()
                    ->toggleable(isToggledHiddenByDefault: true),
                Tables\Columns\TextColumn::make('created_at')
                    ->dateTime()
                    ->sortable()
                    ->toggleable(isToggledHiddenByDefault: true),
                Tables\Columns\TextColumn::make('updated_at')
                    ->dateTime()
                    ->sortable()
                    ->toggleable(isToggledHiddenByDefault: true),
                Tables\Columns\TextColumn::make('deleted_at')
                    ->dateTime()
                    ->sortable()
                    ->toggleable(isToggledHiddenByDefault: true),
            ])
            ->filters([
                Tables\Filters\TrashedFilter::make(),
                Tables\Filters\SelectFilter::make('tournament')
                    ->relationship('tournament', 'label'),
            ])
            ->actions([
                Tables\Actions\EditAction::make(),
            ])
            ->bulkActions([
                Tables\Actions\BulkActionGroup::make([
                    Tables\Actions\DeleteBulkAction::make(),
                    Tables\Actions\ForceDeleteBulkAction::make(),
                    Tables\Actions\RestoreBulkAction::make(),
                ]),
            ])
            ->defaultSort('sequence')
            ->defaultPaginationPageOption(25);
    }

    public static function getRelations(): array
    {
        return [
            //
        ];
    }

    public static function getPages(): array
    {
        return [
            'index' => Pages\ListTournamentMatches::route('/'),
            'create' => Pages\CreateTournamentMatch::route('/create'),
            'edit' => Pages\EditTournamentMatch::route('/{record}/edit'),
        ];
    }

    public static function getEloquentQuery(): Builder
    {
        return parent::getEloquentQuery()
            ->withoutGlobalScopes([
                SoftDeletingScope::class,
            ]);
    }
}
