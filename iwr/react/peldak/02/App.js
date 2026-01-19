import { useState } from "react";
import {
  ActivityIndicator,
  KeyboardAvoidingView,
  Platform,
  Pressable,
  StyleSheet,
  Text,
  TextInput,
  View,
} from "react-native";

/*
KeyboardAvoidingView:
- Prevents the on-screen keyboard from covering input fields.
- Especially important on iOS devices.
Docs: https://reactnative.dev/docs/keyboardavoidingview
*/

/*
Platform:
- Allows platform-specific behavior (iOS vs Android).
- Used here to apply keyboard behavior only on iOS.
Docs: https://reactnative.dev/docs/platform
*/

/*
Pressable:
- Modern and flexible replacement for Button / TouchableOpacity.
- Provides access to pressed state for better UX.
Docs: https://reactnative.dev/docs/pressable
*/
const messagePath = "iskola/iwr/react/peldak/txt/02/php-for-example5/message.php";
const App = () => {
  const [userMessage, setUserMessage] = useState("");
  const [message, setMessage] = useState("");
  const [loading, setLoading] = useState(false);
  const url = "http://192.168.26.32/" + messagePath;
  const token = "217658fhjUjnJkpSLSLSok9948x7238Mnknfhu4721";

  const showTempMessage = (text) => {
    setMessage(text);
    setTimeout(() => setMessage(""), 2500);
  };

  const sendMessage = async () => {
    if (loading) return;

    const trimmed = userMessage.trim();
    if (trimmed.length === 0) {
      showTempMessage("Enter your message!");
      return;
    }

    setLoading(true);
    setMessage("");

    try {
      const response = await fetch(url, {
        method: "POST",
        headers: {
          Accept: "application/json",
          "Content-Type": "application/json; charset=UTF-8",
          Authorization: `Bearer ${token}`,
        },
        body: JSON.stringify({ message: trimmed }),
      });

      if (!response.ok) {
        const text = await response.text();
        throw new Error(`HTTP ${response.status}: ${text}`);
      }

      const data = await response.json();
      setUserMessage("");
      showTempMessage(data.message || "Success!");
    } catch (error) {
      console.error("Error:", error.message);
      showTempMessage("Network / server error!");
    } finally {
      setLoading(false);
    }
  };

  return (
    <KeyboardAvoidingView
      style={styles.safe}
      behavior={Platform.OS === "ios" ? "padding" : undefined}
    >
      <View style={styles.container}>
        <Text style={styles.title}>Send message to PHP</Text>
        <Text style={styles.subtitle}>POST JSON + Bearer token</Text>

        <View style={styles.card}>
          <Text style={styles.label}>Message</Text>

          <TextInput
            style={styles.input}
            placeholder="Type your message..."
            placeholderTextColor="#9CA3AF"
            value={userMessage}
            onChangeText={setUserMessage}
            editable={!loading}
            multiline
            maxLength={200}
          />

          <Pressable
            style={({ pressed }) => [
              styles.button,
              loading && styles.buttonDisabled,
              pressed && !loading && styles.buttonPressed,
            ]}
            onPress={sendMessage}
            disabled={loading}
          >
            {loading ? (
              <View style={styles.row}>
                <ActivityIndicator size="small" color="#fff" />
                <Text style={styles.buttonText}>Sending...</Text>
              </View>
            ) : (
              <Text style={styles.buttonText}>Send</Text>
            )}
          </Pressable>

          {!!message && (
            <View style={styles.messageBox}>
              <Text style={styles.messageText}>{message}</Text>
            </View>
          )}

          <Text style={styles.hint}>Server: {url}</Text>
        </View>
      </View>
    </KeyboardAvoidingView>
  );
};

const styles = StyleSheet.create({
  safe: {
    flex: 1,
    backgroundColor: "#F3F4F6",
  },
  container: {
    flex: 1,
    padding: 20,
    justifyContent: "center",
  },
  title: {
    fontSize: 26,
    fontWeight: "800",
    color: "#111827",
    textAlign: "center",
  },
  subtitle: {
    marginTop: 6,
    fontSize: 14,
    color: "#6B7280",
    textAlign: "center",
    marginBottom: 16,
  },
  card: {
    backgroundColor: "#FFFFFF",
    borderRadius: 18,
    padding: 16,
    borderWidth: 1,
    borderColor: "#E5E7EB",
  },
  label: {
    fontSize: 13,
    fontWeight: "700",
    color: "#374151",
    marginBottom: 8,
  },
  input: {
    minHeight: 90,
    borderRadius: 14,
    borderWidth: 1,
    borderColor: "#E5E7EB",
    backgroundColor: "#F9FAFB",
    paddingHorizontal: 12,
    paddingVertical: 10,
    fontSize: 15,
    color: "#111827",
    textAlignVertical: "top",
  },
  button: {
    marginTop: 12,
    borderRadius: 14,
    backgroundColor: "#111827",
    paddingVertical: 12,
    alignItems: "center",
  },
  buttonPressed: {
    opacity: 0.85,
  },
  buttonDisabled: {
    opacity: 0.6,
  },
  buttonText: {
    color: "#FFFFFF",
    fontWeight: "800",
    fontSize: 16,
  },
  row: {
    flexDirection: "row",
    gap: 10,
    alignItems: "center",
  },
  messageBox: {
    marginTop: 12,
    padding: 12,
    borderRadius: 14,
    backgroundColor: "#EEF2FF",
    borderWidth: 1,
    borderColor: "#E0E7FF",
  },
  messageText: {
    color: "#1F2937",
    fontSize: 14,
    fontWeight: "600",
  },
  hint: {
    marginTop: 10,
    fontSize: 11,
    color: "#9CA3AF",
  },
});

export default App;
