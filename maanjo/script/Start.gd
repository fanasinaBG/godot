extends Button

func _ready() -> void:
	# Connexion correcte du signal dans Godot 4
	pressed.connect(_on_Button_pressed)

func _on_Button_pressed() -> void:
	# Méthode recommandée pour changer de scène dans Godot 4
	get_tree().call_deferred("change_scene_to_file", "res://main.tscn")
