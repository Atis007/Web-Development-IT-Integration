import { useState } from "react";
import { StatusBar } from "expo-status-bar";
import { StyleSheet, View, TextInput, Text, Button } from "react-native";

export default function App() {
  const [name, setName] = useState("");
  const [inputValue, setInputValue] = useState("");

  function handleSubmit() {
    setName(inputValue.trim());
  }

  return (
    <View style={styles.container}>
      <StatusBar style="auto" />
      <TextInput
        placeholder="Enter your name here"
        style={styles.input}
        value={inputValue}
        onChangeText={setInputValue}
      />
      <Button title="Submit" onPress={handleSubmit} />
      <Text>{name ? name : "No name entered"}</Text>
    </View>
  );
}

const styles = StyleSheet.create({
  container: {
    flex: 1,
    backgroundColor: "#fff",
    alignItems: "center",
    justifyContent: "center",
  },
  input: {
    width: "80%",
    padding: 10,
    borderWidth: 1,
    borderColor: "#ccc",
    borderRadius: 4,
    marginBottom: 12,
  },
});
