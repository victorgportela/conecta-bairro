// GENERATED CODE - DO NOT MODIFY BY HAND

part of 'servico.dart';

// **************************************************************************
// JsonSerializableGenerator
// **************************************************************************

Servico _$ServicoFromJson(Map<String, dynamic> json) => Servico(
      id: (json['id'] as num).toInt(),
      nome: json['nome'] as String,
      descricao: json['descricao'] as String,
      nomePrestador: json['nome_prestador'] as String,
      telefone: json['telefone'] as String,
      bairro: json['bairro'] as String,
      cidade: json['cidade'] as String,
      createdAt: json['created_at'] as String,
      updatedAt: json['updated_at'] as String,
    );

Map<String, dynamic> _$ServicoToJson(Servico instance) => <String, dynamic>{
      'id': instance.id,
      'nome': instance.nome,
      'descricao': instance.descricao,
      'nome_prestador': instance.nomePrestador,
      'telefone': instance.telefone,
      'bairro': instance.bairro,
      'cidade': instance.cidade,
      'created_at': instance.createdAt,
      'updated_at': instance.updatedAt,
    };
