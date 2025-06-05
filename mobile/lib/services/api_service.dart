import 'dart:convert';
import 'package:http/http.dart' as http;
import 'package:shared_preferences/shared_preferences.dart';
import '../models/user.dart';
import '../models/servico.dart';

class ApiService {
  static const String baseUrl = 'http://localhost:8000/api';
  
  String? _token;

  // Getter para o token
  String? get token => _token;

  // Carregar token salvo
  Future<void> loadToken() async {
    final prefs = await SharedPreferences.getInstance();
    _token = prefs.getString('auth_token');
  }

  // Salvar token
  Future<void> saveToken(String token) async {
    final prefs = await SharedPreferences.getInstance();
    await prefs.setString('auth_token', token);
    _token = token;
  }

  // Remover token
  Future<void> removeToken() async {
    final prefs = await SharedPreferences.getInstance();
    await prefs.remove('auth_token');
    _token = null;
  }

  // Headers padrão
  Map<String, String> get headers {
    final Map<String, String> headers = {
      'Content-Type': 'application/json',
      'Accept': 'application/json',
    };
    
    if (_token != null) {
      headers['Authorization'] = 'Bearer $_token';
    }
    
    return headers;
  }

  // Verificar se está autenticado
  bool get isAuthenticated => _token != null;

  // Registro
  Future<Map<String, dynamic>> register({
    required String name,
    required String email,
    required String password,
    required String passwordConfirmation,
  }) async {
    final response = await http.post(
      Uri.parse('$baseUrl/register'),
      headers: headers,
      body: jsonEncode({
        'name': name,
        'email': email,
        'password': password,
        'password_confirmation': passwordConfirmation,
      }),
    );

    final data = jsonDecode(response.body);
    
    if (response.statusCode == 201) {
      await saveToken(data['access_token']);
      return {
        'success': true,
        'user': User.fromJson(data['user']),
        'token': data['access_token'],
      };
    } else {
      return {
        'success': false,
        'message': data['message'] ?? 'Erro no registro',
        'errors': data['errors'],
      };
    }
  }

  // Login
  Future<Map<String, dynamic>> login({
    required String email,
    required String password,
  }) async {
    final response = await http.post(
      Uri.parse('$baseUrl/login'),
      headers: headers,
      body: jsonEncode({
        'email': email,
        'password': password,
      }),
    );

    final data = jsonDecode(response.body);
    
    if (response.statusCode == 200) {
      await saveToken(data['access_token']);
      return {
        'success': true,
        'user': User.fromJson(data['user']),
        'token': data['access_token'],
      };
    } else {
      return {
        'success': false,
        'message': data['message'] ?? 'Credenciais inválidas',
        'errors': data['errors'],
      };
    }
  }

  // Logout
  Future<void> logout() async {
    if (_token != null) {
      try {
        await http.post(
          Uri.parse('$baseUrl/logout'),
          headers: headers,
        );
      } catch (e) {
        // Ignorar erros de logout
      }
    }
    await removeToken();
  }

  // Buscar usuário atual
  Future<User?> getCurrentUser() async {
    if (!isAuthenticated) return null;

    try {
      final response = await http.get(
        Uri.parse('$baseUrl/user'),
        headers: headers,
      );

      if (response.statusCode == 200) {
        final data = jsonDecode(response.body);
        return User.fromJson(data);
      }
    } catch (e) {
      print('Erro ao buscar usuário: $e');
    }
    
    return null;
  }

  // Listar serviços
  Future<List<Servico>> getServicos() async {
    try {
      final response = await http.get(
        Uri.parse('$baseUrl/servicos'),
        headers: headers,
      );

      if (response.statusCode == 200) {
        final List<dynamic> data = jsonDecode(response.body);
        return data.map((json) => Servico.fromJson(json)).toList();
      }
    } catch (e) {
      print('Erro ao buscar serviços: $e');
    }
    
    return [];
  }

  // Buscar serviços
  Future<List<Servico>> searchServicos({
    String? cidade,
    String? bairro,
    String? nome,
  }) async {
    try {
      final queryParams = <String, String>{};
      if (cidade != null && cidade.isNotEmpty) queryParams['cidade'] = cidade;
      if (bairro != null && bairro.isNotEmpty) queryParams['bairro'] = bairro;
      if (nome != null && nome.isNotEmpty) queryParams['nome'] = nome;

      final uri = Uri.parse('$baseUrl/servicos/search').replace(
        queryParameters: queryParams.isNotEmpty ? queryParams : null,
      );

      final response = await http.get(uri, headers: headers);

      if (response.statusCode == 200) {
        final List<dynamic> data = jsonDecode(response.body);
        return data.map((json) => Servico.fromJson(json)).toList();
      }
    } catch (e) {
      print('Erro ao buscar serviços: $e');
    }
    
    return [];
  }

  // Criar serviço
  Future<Map<String, dynamic>> createServico({
    required String nome,
    required String descricao,
    required String nomePrestador,
    required String telefone,
    required String bairro,
    required String cidade,
  }) async {
    if (!isAuthenticated) {
      return {'success': false, 'message': 'Usuário não autenticado'};
    }

    try {
      final response = await http.post(
        Uri.parse('$baseUrl/servicos'),
        headers: headers,
        body: jsonEncode({
          'nome': nome,
          'descricao': descricao,
          'nome_prestador': nomePrestador,
          'telefone': telefone,
          'bairro': bairro,
          'cidade': cidade,
        }),
      );

      final data = jsonDecode(response.body);
      
      if (response.statusCode == 201) {
        return {
          'success': true,
          'servico': Servico.fromJson(data['servico']),
          'message': data['message'],
        };
      } else {
        return {
          'success': false,
          'message': data['message'] ?? 'Erro ao criar serviço',
          'errors': data['errors'],
        };
      }
    } catch (e) {
      return {
        'success': false,
        'message': 'Erro de conexão: $e',
      };
    }
  }
} 