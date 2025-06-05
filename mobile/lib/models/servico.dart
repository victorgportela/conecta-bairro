import 'package:json_annotation/json_annotation.dart';

part 'servico.g.dart';

@JsonSerializable()
class Servico {
  final int id;
  final String nome;
  final String descricao;
  @JsonKey(name: 'nome_prestador')
  final String nomePrestador;
  final String telefone;
  final String bairro;
  final String cidade;
  @JsonKey(name: 'created_at')
  final String createdAt;
  @JsonKey(name: 'updated_at')
  final String updatedAt;

  Servico({
    required this.id,
    required this.nome,
    required this.descricao,
    required this.nomePrestador,
    required this.telefone,
    required this.bairro,
    required this.cidade,
    required this.createdAt,
    required this.updatedAt,
  });

  factory Servico.fromJson(Map<String, dynamic> json) => _$ServicoFromJson(json);
  Map<String, dynamic> toJson() => _$ServicoToJson(this);

  // Getters para formatação
  String get localCompleto => '$bairro, $cidade';
  String get telefoneFormatado => telefone;
  String get whatsappUrl => 'https://wa.me/55${telefone.replaceAll(RegExp(r'[^0-9]'), '')}';
} 