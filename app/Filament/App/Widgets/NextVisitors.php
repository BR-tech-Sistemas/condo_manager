<?php

namespace App\Filament\App\Widgets;

use App\Models\Visitor;
use App\Traits\VisibilityOfWidget;
use Filament\Facades\Filament;
use Filament\Forms\Components\DateTimePicker;
use Filament\Forms\Components\Section;
use Filament\Forms\Components\Select;
use Filament\Forms\Components\Split;
use Filament\Forms\Components\TextInput;
use Filament\Notifications\Notification;
use Filament\Tables;
use Filament\Tables\Table;
use Filament\Widgets\TableWidget as BaseWidget;
use Illuminate\Database\Eloquent\Builder;
use Illuminate\Database\Eloquent\Model;
use Leandrocfe\FilamentPtbrFormFields\Document;
use Leandrocfe\FilamentPtbrFormFields\PhoneNumber;

class NextVisitors extends BaseWidget
{
    use VisibilityOfWidget;

    protected static ?int $sort = -1;
    protected static ?string $heading = 'Próximos Visitantes Cadastrados';
    protected int|string|array $columnSpan = 'full';

    /**
     * Set the roles allowed to view this widget.
     *
     * @return string[]
     */
    protected static function getRolesAllowed(): array
    {
        return ['Síndico', 'Porteiro'];
    }

    public function table(Table $table): Table
    {
        return $table
            ->query(
                Visitor::query()
                    ->with(['condo', 'apartment.block'])
                    ->where('entry_date', '>=', now())
                    ->orderBy('entry_date')
            )
            ->emptyStateHeading('Nenhum visitante cadastrado.')
            ->paginated(false)
            ->emptyStateIcon('heroicon-o-identification')
            ->columns([
                Tables\Columns\TextColumn::make('apartment.block.title')
                    ->alignCenter()
                    ->label('Bloco')
                    ->numeric(),
                Tables\Columns\TextColumn::make('apartment_id')
                    ->alignCenter()
                    ->label('Apartamento')
                    ->numeric(),
                Tables\Columns\TextColumn::make('name')
                    ->label('Nome'),
                Tables\Columns\TextColumn::make('entry_date')
                    ->label('Data de Entrada')
                    ->dateTime('d/m/Y H:i'),
                Tables\Columns\TextColumn::make('exit_date')
                    ->label('Data de Saída')
                    ->dateTime('d/m/Y H:i'),
            ])
            ->actions([
                Tables\Actions\Action::make('Registrar Entrada')
                    ->color('warning')
                    ->visible(auth()->user()->hasAnyRole(['Síndico', 'Porteiro']))
                    ->action(function (Visitor $visitor) {
                        $visitor->loadMissing('apartment.residents.user');
                        $recipients = $visitor->apartment->residents;
                        foreach ($recipients as $recipient) {
                            Notification::make()
                                ->title('Entrada de Visitante Registrada')
                                ->warning()
                                ->sendToDatabase($recipient->user);
                        }
                        Notification::make()
                            ->title('Entrada Registrada')
                            ->success()
                            ->send();
                    })
                    ->icon('heroicon-o-arrow-left-end-on-rectangle'),
            ])
            ->headerActions([
                Tables\Actions\CreateAction::make('Cadastrar novo Visitante')
                    ->mutateFormDataUsing(function (array $data): array {
                        $data['condo_id'] = Filament::getTenant()->id;
                        return $data;
                    })
                    ->label('Cadastrar Visitante')
                    ->slideOver()
                    ->createAnother(false)
                    ->form([
                        Split::make([
                            Section::make('Informações Básicas')
                                ->columns([
                                    'default' => 1,
                                    'sm' => 1,
                                    'md' => 2,
                                    'lg' => 1,
                                    'xl' => 2,
                                ])
                                ->collapsible()
                                ->description('informações básicas sobre o apartamento.')
                                ->icon('heroicon-s-building-office')
                                ->schema([
                                    Select::make('apartment_id')
                                        ->label('Apartamento')
                                        ->searchable()
                                        ->preload()
                                        ->relationship(
                                            name: 'apartment',
                                            titleAttribute: 'title',
                                            modifyQueryUsing: function (Builder $query) {
                                                if (! auth()->user()->hasAnyRole(['Síndico', 'Porteiro'])){
                                                    $query->whereIn('id', auth()->user()->apartments->pluck('id'));
                                                }
                                            }
                                        )
                                        ->getOptionLabelFromRecordUsing(function (Model $record) {
                                            $record->load('block');
                                            return "Bloco {$record->block->title}: Apto {$record->title}";
                                        })
                                        ->required()
                                        ->native(false),
                                    TextInput::make('name')
                                        ->label('Nome')
                                        ->required()
                                        ->maxLength(255),
                                    TextInput::make('rg')
                                        ->label('RG')
                                        ->maxLength(255),
                                    Document::make('cpf')
                                        ->label('CPF')
                                        ->validation(false)
                                        ->cpf()
                                        ->maxLength(14),
                                    PhoneNumber::make('phone')
                                        ->label('Telefone')
                                        ->format('(99) 99999-9999')
                                        ->required()
                                        ->maxLength(15),
                                    TextInput::make('email')
                                        ->label('E-mail')
                                        ->email()
                                        ->maxLength(255),
                                ]),
                        ]),
                        Split::make([
                            Section::make('Datas')
                                ->collapsible()
                                ->description('informações Período de liberação do visitante.')
                                ->icon('heroicon-o-cog')
                                ->columns([
                                    'default' => 1,
                                    'sm' => 1,
                                    'md' => 2,
                                    'lg' => 1,
                                    'xl' => 2,
                                ])
                                ->schema([
                                    DateTimePicker::make('entry_date')
                                        ->label('Data de Entrada')
                                        ->after('now')
                                        ->seconds(false)
                                        ->displayFormat('d/m/Y H:i')
                                        ->native(false)
                                        ->required(),
                                    DateTimePicker::make('exit_date')
                                        ->label('Data de Saída')
                                        ->after('entry_date')
                                        ->seconds(false)
                                        ->displayFormat('d/m/Y H:i')
                                        ->native(false)
                                        ->required(),
                                ]),
                        ]),
                    ])
                    ->modelLabel('Visitante')
                    ->icon('heroicon-o-identification')
            ]);
    }
}
