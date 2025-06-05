import 'package:flutter/foundation.dart';
import '../models/user.dart';
import 'api_service.dart';

class AuthProvider extends ChangeNotifier {
  final ApiService _apiService = ApiService();
  User? _user;
  bool _isLoading = false;
  String? _errorMessage;

  // Getters
  User? get user => _user;
  bool get isLoading => _isLoading;
  String? get errorMessage => _errorMessage;
  bool get isAuthenticated => _user != null && _apiService.isAuthenticated;

  // Inicializar provider
  Future<void> initialize() async {
    _setLoading(true);
    await _apiService.loadToken();
    
    if (_apiService.isAuthenticated) {
      _user = await _apiService.getCurrentUser();
      if (_user == null) {
        // Token inválido, fazer logout
        await logout();
      }
    }
    
    _setLoading(false);
  }

  // Login
  Future<bool> login(String email, String password) async {
    _setLoading(true);
    _clearError();

    try {
      final result = await _apiService.login(
        email: email,
        password: password,
      );

      if (result['success']) {
        _user = result['user'];
        _setLoading(false);
        return true;
      } else {
        _setError(result['message'] ?? 'Erro no login');
        _setLoading(false);
        return false;
      }
    } catch (e) {
      _setError('Erro de conexão: $e');
      _setLoading(false);
      return false;
    }
  }

  // Registro
  Future<bool> register({
    required String name,
    required String email,
    required String password,
    required String passwordConfirmation,
  }) async {
    _setLoading(true);
    _clearError();

    try {
      final result = await _apiService.register(
        name: name,
        email: email,
        password: password,
        passwordConfirmation: passwordConfirmation,
      );

      if (result['success']) {
        _user = result['user'];
        _setLoading(false);
        return true;
      } else {
        _setError(result['message'] ?? 'Erro no registro');
        _setLoading(false);
        return false;
      }
    } catch (e) {
      _setError('Erro de conexão: $e');
      _setLoading(false);
      return false;
    }
  }

  // Logout
  Future<void> logout() async {
    _setLoading(true);
    await _apiService.logout();
    _user = null;
    _setLoading(false);
  }

  // Métodos auxiliares
  void _setLoading(bool loading) {
    _isLoading = loading;
    notifyListeners();
  }

  void _setError(String error) {
    _errorMessage = error;
    notifyListeners();
  }

  void _clearError() {
    _errorMessage = null;
    notifyListeners();
  }

  void clearError() {
    _clearError();
  }

  // Getter para o ApiService (usado por outros providers)
  ApiService get apiService => _apiService;
} 